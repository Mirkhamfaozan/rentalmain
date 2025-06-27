<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Exception;

class FrontPaymentController extends Controller
{
    private $serverKey;
    private $clientKey;
    private $isProduction;
    private $snapUrl;
    private $coreApiUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production', false);

        $baseUrl = $this->isProduction ? 'https://api.midtrans.com/v2' : 'https://api.sandbox.midtrans.com/v2';
        $this->coreApiUrl = $baseUrl;
        $this->snapUrl = $this->isProduction ? 'https://app.midtrans.com/snap/v1' : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    public function create($orderId)
    {
        try {
            $order = Order::with('product', 'payment')->findOrFail($orderId);

            if ($order->hasPayment() && !in_array($order->payment->status, ['failed', 'expired', 'cancelled'])) {
                return redirect()->route('payment.show', $order->payment->id);
            }

            if ($order->status !== 'pending') {
                return redirect()->back()->with('error', 'Pesanan tidak dapat diproses untuk pembayaran.');
            }

            $paymentMethods = [
                'bank_transfer' => 'Transfer Bank',
                'credit_card' => 'Kartu Kredit/Debit',
                'gopay' => 'GoPay',
                'shopeepay' => 'ShopeePay',
                'qris' => 'QRIS',
            ];

            return view('frontend.payment.create', compact('order', 'paymentMethods'));
        } catch (Exception $e) {
            Log::error('Error loading payment page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function store(Request $request, $orderId)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,credit_card,gopay,shopeepay,dana,ovo,qris,indomaret,alfamart',
            'bank_type' => 'required_if:payment_method,bank_transfer|in:bca,bni,bri,mandiri,permata,cimb',
        ], [
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran yang dipilih tidak valid.',
            'bank_type.required_if' => 'Silakan pilih bank untuk transfer.',
            'bank_type.in' => 'Bank yang dipilih tidak valid.',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::with('product')->findOrFail($orderId);
            Log::info('Processing payment for order', ['order_id' => $orderId, 'order_status' => $order->status]);

            if ($order->status !== 'pending') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Pesanan dengan status "' . $order->status . '" tidak dapat diproses untuk pembayaran.');
            }

            if ($order->hasPayment() && in_array($order->payment->transaction_status, ['pending', 'settlement'])) {
                DB::rollBack();
                return redirect()->route('payment.show', $order->payment->id);
            }

            $totalAmount = $order->total_harga + $order->ongkir;

            if ($totalAmount <= 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Total pembayaran tidak valid.');
            }

            $transactionId = 'ORDER-' . $order->id . '-' . time();

            $midtransResponse = $this->createMidtransPayment($order, $transactionId, $request->payment_method, $request->bank_type);

            if (!$midtransResponse['success']) {
                DB::rollBack();
                return redirect()->back()->with('error', $midtransResponse['message']);
            }

            $paymentData = [
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'payment_type' => $request->payment_method,
                'gross_amount' => $totalAmount,
                'transaction_status' => 'pending',
                'status' => 'pending',
                'transaction_time' => now(),
                'payment_response' => json_encode($midtransResponse['data']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $responseData = $midtransResponse['data'];

            switch ($request->payment_method) {
                case 'bank_transfer':
                    $paymentData['bank'] = $request->bank_type;
                    $paymentData['va_number'] = $responseData['va_numbers'][0]['va_number'] ?? null;
                    $paymentData['expiry_time'] = $responseData['expiry_time'] ?? now()->addHours(24);
                    break;

                case 'credit_card':
                    $paymentData['redirect_url'] = $responseData['redirect_url'] ?? null;
                    $paymentData['expiry_time'] = $responseData['expiry_time'] ?? now()->addMinutes(15);
                    break;

                case 'gopay':
                case 'shopeepay':
                case 'dana':
                case 'ovo':
                    $paymentData['payment_code'] = $responseData['transaction_id'] ?? null;
                    $paymentData['deeplink_redirect'] = $responseData['actions'][0]['url'] ?? null;
                    $paymentData['qr_string'] = $responseData['qr_string'] ?? null;
                    $paymentData['expiry_time'] = $responseData['expiry_time'] ?? now()->addMinutes(30);
                    break;

                case 'qris':
                    $paymentData['qr_string'] = $responseData['qr_string'] ?? null;
                    $paymentData['expiry_time'] = $responseData['expiry_time'] ?? now()->addMinutes(30);
                    break;

                case 'indomaret':
                case 'alfamart':
                    $paymentData['payment_code'] = $responseData['payment_code'] ?? null;
                    $paymentData['expiry_time'] = $responseData['expiry_time'] ?? now()->addDays(1);
                    break;
            }

            $payment = Payment::create($paymentData);

            if (!$payment) {
                throw new Exception('Gagal menyimpan data pembayaran ke database.');
            }

            Log::info('Payment created successfully', [
                'payment_id' => $payment->id,
                'transaction_id' => $transactionId,
                'order_id' => $orderId,
                'method' => $request->payment_method,
                'amount' => $totalAmount
            ]);

            DB::commit();

            return redirect()->route('payment.show', $payment->id)
                ->with('success', 'Pembayaran berhasil dibuat. Silakan selesaikan pembayaran Anda.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Order not found for payment', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Database error during payment creation', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'sql_code' => $e->getCode()
            ]);

            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'Data pembayaran sudah ada atau terjadi duplikasi.');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan database. Silakan coba lagi.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment creation error', [
                'order_id' => $orderId,
                'payment_method' => $request->payment_method,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function createMidtransPayment($order, $transactionId, $paymentMethod, $bankType = null)
    {
        try {
            $customerDetails = [
                'first_name' => substr($order->customer_name ?? 'Customer', 0, 20),
                'email' => filter_var($order->customer_email ?? 'customer@example.com', FILTER_VALIDATE_EMAIL),
                'phone' => preg_replace('/[^0-9]/', '', $order->customer_phone ?? '08123456789'),
            ];

            $totalAmount = $order->total_harga + $order->ongkir;

            $itemDetails = [
                [
                    'id' => 'ORDER-' . $order->id,
                    'price' => (int) round($order->total_harga),
                    'quantity' => 1,
                    'name' => substr($order->product->name ?? 'Product', 0, 50),
                ],
                [
                    'id' => 'ONGKIR-' . $order->id,
                    'price' => (int) round($order->ongkir),
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim',
                ]
            ];

            $transactionDetails = [
                'order_id' => $transactionId,
                'gross_amount' => (int) round($totalAmount),
            ];

            $paymentConfig = $this->getPaymentMethodConfig($paymentMethod, $bankType);

            $payload = [
                'payment_type' => $paymentConfig['payment_type'],
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
            ];

            if (isset($paymentConfig['payment_params'])) {
                $payload = array_merge($payload, $paymentConfig['payment_params']);
            }

            Log::debug('Midtrans payload', [
                'payload' => $payload,
                'endpoint' => $this->coreApiUrl . '/charge'
            ]);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
            ])->post($this->coreApiUrl . '/charge', $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('Midtrans payment created successfully', [
                    'transaction_id' => $transactionId,
                    'status_code' => $responseData['status_code'],
                    'transaction_status' => $responseData['transaction_status'],
                ]);

                return [
                    'success' => true,
                    'data' => $responseData,
                    'message' => 'Payment created successfully'
                ];
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error_messages'][0] ??
                    $errorData['status_message'] ??
                    'Payment creation failed';

                if (isset($errorData['status_code'])) {
                    switch ($errorData['status_code']) {
                        case '400':
                            $errorMessage = 'Invalid payment data';
                            break;
                        case '401':
                            $errorMessage = 'Authentication failed';
                            break;
                        case '402':
                            $errorMessage = 'Payment failed';
                            break;
                    }
                }

                Log::error('Midtrans API error', [
                    'transaction_id' => $transactionId,
                    'status_code' => $response->status(),
                    'error' => $errorData,
                    'message' => $errorMessage
                ]);

                return [
                    'success' => false,
                    'data' => $errorData,
                    'message' => $errorMessage
                ];
            }
        } catch (Exception $e) {
            Log::error('Error creating Midtrans payment', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'data' => null,
                'message' => 'Failed to create payment: ' . $e->getMessage()
            ];
        }
    }

    private function getPaymentMethodConfig($paymentMethod, $bankType = null)
    {
        switch ($paymentMethod) {
            case 'bank_transfer':
                return [
                    'payment_type' => 'bank_transfer',
                    'payment_params' => [
                        'bank_transfer' => [
                            'bank' => $bankType
                        ]
                    ]
                ];

            case 'credit_card':
                return [
                    'payment_type' => 'credit_card',
                    'payment_params' => [
                        'credit_card' => [
                            'secure' => true,
                            'save_card' => false
                        ]
                    ]
                ];

            case 'gopay':
                return [
                    'payment_type' => 'gopay',
                    'payment_params' => [
                        'gopay' => [
                            'enable_callback' => true,
                            'callback_url' => route('payment.callback')
                        ]
                    ]
                ];

            case 'shopeepay':
                return [
                    'payment_type' => 'shopeepay',
                    'payment_params' => [
                        'shopeepay' => [
                            'callback_url' => route('payment.callback')
                        ]
                    ]
                ];

            case 'dana':
                return [
                    'payment_type' => 'dana',
                    'payment_params' => [
                        'dana' => [
                            'callback_url' => route('payment.callback')
                        ]
                    ]
                ];

            case 'ovo':
                return [
                    'payment_type' => 'ovo',
                    'payment_params' => [
                        'ovo' => [
                            'callback_url' => route('payment.callback')
                        ]
                    ]
                ];

            case 'qris':
                return [
                    'payment_type' => 'qris',
                    'payment_params' => [
                        'qris' => [
                            'acquirer' => 'gopay'
                        ]
                    ]
                ];

            case 'indomaret':
                return [
                    'payment_type' => 'cstore',
                    'payment_params' => [
                        'cstore' => [
                            'store' => 'indomaret',
                            'message' => 'Payment for Order #' . time(),
                            'indomaret_free_text_1' => 'Thank you for shopping',
                            'indomaret_free_text_2' => 'Please pay before expiry',
                            'indomaret_free_text_3' => 'Call CS if any questions'
                        ]
                    ]
                ];

            case 'alfamart':
                return [
                    'payment_type' => 'cstore',
                    'payment_params' => [
                        'cstore' => [
                            'store' => 'alfamart',
                            'message' => 'Payment for Order #' . time(),
                            'alfamart_free_text_1' => 'Thank you for shopping',
                            'alfamart_free_text_2' => 'Please pay before expiry',
                            'alfamart_free_text_3' => 'Call CS if any questions'
                        ]
                    ]
                ];

            default:
                throw new Exception('Unsupported payment method: ' . $paymentMethod);
        }
    }

    public function show($paymentId)
    {
        try {
            $payment = Payment::with('order.product')->findOrFail($paymentId);

            if ($payment->transaction_status === 'pending') {
                $this->checkPaymentStatus($payment);
                $payment->refresh();
            }

            return view('frontend.payment.show', compact('payment'));
        } catch (Exception $e) {
            Log::error('Error loading payment details', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan.');
        }
    }

    private function checkPaymentStatus($payment)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
            ])->get($this->coreApiUrl . '/' . $payment->transaction_id . '/status');

            if ($response->successful()) {
                $statusData = $response->json();
                $this->updatePaymentFromMidtrans($payment, $statusData);
            }
        } catch (Exception $e) {
            Log::error('Error checking payment status', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function webhook(Request $request)
    {
        try {
            Log::info('Payment webhook received', $request->all());

            $serverKey = $this->serverKey;
            $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashedKey !== $request->signature_key) {
                Log::warning('Invalid webhook signature', ['request' => $request->all()]);
                return response()->json(['status' => 'invalid signature'], 401);
            }

            if ($request->has('order_id') && $request->has('transaction_status')) {
                $transactionId = $request->order_id;
                $payment = Payment::where('transaction_id', $transactionId)->first();

                if ($payment) {
                    $this->updatePaymentFromMidtrans($payment, $request->all());

                    Log::info('Payment updated via webhook', [
                        'payment_id' => $payment->id,
                        'transaction_id' => $transactionId,
                        'status' => $request->transaction_status
                    ]);
                } else {
                    Log::warning('Payment not found for webhook', ['transaction_id' => $transactionId]);
                }
            }

            return response()->json(['status' => 'ok']);
        } catch (Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function updatePaymentFromMidtrans($payment, $midtransData)
    {
        try {
            $transactionStatus = $midtransData['transaction_status'];
            $fraudStatus = $midtransData['fraud_status'] ?? null;

            $updateData = [
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_response' => json_encode($midtransData),
                'transaction_time' => now(),
            ];

            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'challenge') {
                        $updateData['status'] = 'pending';
                    } else if ($fraudStatus == 'accept') {
                        $updateData['status'] = 'success';
                        $payment->order->update(['status' => 'confirmed']);
                        $payment->order->product->update(['is_available' => 0]);
                    }
                    break;

                case 'settlement':
                    $updateData['status'] = 'success';
                    $payment->order->update(['status' => 'confirmed']);
                    $payment->order->product->update(['is_available' => 0]);
                    break;

                case 'expire':
                    $updateData['status'] = 'expired';
                    break;

                case 'cancel':
                case 'deny':
                case 'failure':
                    $updateData['status'] = 'failed';
                    break;

                case 'refund':
                case 'partial_refund':
                    $updateData['status'] = 'refunded';
                    $payment->order->product->update(['is_available' => 1]);
                    break;

                case 'pending':
                    $updateData['status'] = 'pending';
                    break;
            }

            $payment->update($updateData);

            return true;
        } catch (Exception $e) {
            Log::error('Error updating payment from Midtrans data', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function confirm(Request $request, $paymentId)
    {
        $request->validate([
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500',
        ], [
            'proof_image.image' => 'File harus berupa gambar.',
            'proof_image.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'proof_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        DB::beginTransaction();

        try {
            $payment = Payment::findOrFail($paymentId);

            if (!in_array($payment->transaction_status, ['pending', 'settlement'])) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Pembayaran dengan status "' . $payment->transaction_status . '" tidak dapat dikonfirmasi.');
            }

            $updateData = [
                'transaction_status' => 'settlement',
                'status' => 'success',
                'transaction_time' => now(),
            ];

            $notesArray = [];
            if ($request->hasFile('proof_image')) {
                $imagePath = $request->file('proof_image')->store('payment_proofs', 'public');
                $notesArray[] = "Bukti transfer: " . $imagePath;
            }

            if ($request->notes) {
                $notesArray[] = $request->notes;
            }

            if (!empty($notesArray)) {
                $paymentResponse = json_decode($payment->payment_response ?? '{}', true);
                $paymentResponse['confirmation_notes'] = implode("\n", $notesArray);
                $updateData['payment_response'] = json_encode($paymentResponse);
            }

            $payment->update($updateData);
            $payment->order->update(['status' => 'confirmed']);
            $payment->order->product->update(['is_available' => 0]);

            Log::info('Payment confirmed successfully', [
                'payment_id' => $paymentId,
                'transaction_id' => $payment->transaction_id,
                'order_id' => $payment->order_id
            ]);

            DB::commit();

            return redirect()->route('payment.show', $payment->id)
                ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Pesanan Anda akan segera diproses.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment confirmation error', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mengonfirmasi pembayaran: ' . $e->getMessage());
        }
    }

    public function cancel($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);

            if ($payment->transaction_status === 'pending') {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
                ])->post($this->coreApiUrl . '/' . $payment->transaction_id . '/cancel');

                if ($response->successful()) {
                    $payment->update([
                        'transaction_status' => 'cancel',
                        'status' => 'cancelled'
                    ]);

                    return redirect()->back()->with('success', 'Pembayaran berhasil dibatalkan.');
                } else {
                    return redirect()->back()->with('error', 'Gagal membatalkan pembayaran.');
                }
            } else {
                return redirect()->back()->with('error', 'Pembayaran tidak dapat dibatalkan.');
            }
        } catch (Exception $e) {
            Log::error('Error cancelling payment', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function checkExpiredPayments()
    {
        try {
            $expiredPayments = Payment::where('transaction_status', 'pending')
                ->where('expiry_time', '<', now())
                ->get();

            foreach ($expiredPayments as $payment) {
                $payment->update([
                    'transaction_status' => 'expire',
                    'status' => 'expired'
                ]);

                Log::info('Payment expired automatically', [
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id
                ]);
            }

            return $expiredPayments->count();
        } catch (Exception $e) {
            Log::error('Error checking expired payments', ['error' => $e->getMessage()]);
            return 0;
        }
    }
}
