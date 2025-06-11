<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Data untuk admin
        if ($user->isAdmin()) {
            $data = $this->getAdminDashboardData();
        }
        // Data untuk rental
        elseif ($user->isRental()) {
            $data = $this->getRentalDashboardData();
        }
        // Data untuk customer
        else {
            $data = $this->getCustomerDashboardData();
        }

        return view('admin.dashboard', compact('data'));
    }

    /**
     * Get dashboard data for admin users
     */
    private function getAdminDashboardData()
    {
        // Statistics Cards
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Payment::where('status', 'success')->sum('gross_amount');
        $totalUsers = User::count();
        $activeRentals = Order::where('status', 'ongoing')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        // Monthly Revenue Chart Data
        $monthlyRevenue = Payment::where('status', 'success')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(gross_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create()->month($item->month)->format('M') => $item->total];
            });

        // Fill missing months with 0
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($months as $month) {
            if (!$monthlyRevenue->has($month)) {
                $monthlyRevenue[$month] = 0;
            }
        }

        // Order Status Distribution
        $orderStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        // Recent Orders
        $recentOrders = Order::with(['user', 'product', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        // Top Products by Revenue
        $topProducts = Product::with('user')
            ->withSum(['orders as total_revenue' => function ($query) {
                $query->whereHas('payment', function ($q) {
                    $q->where('status', 'success');
                });
            }], 'total_harga')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Payment Methods Distribution
        $paymentMethods = Payment::select('payment_type', DB::raw('count(*) as count'))
            ->where('status', 'success')
            ->groupBy('payment_type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->payment_type => $item->count];
            });

        // Daily Orders (Last 7 days)
        $dailyOrders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [now()->subDays(6), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->date)->format('M d') => $item->count];
            });

        // Most Active Rental Owners
        $activeRentals = User::where('role', 'rental')
            ->withCount(['products', 'products as active_orders' => function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->whereIn('status', ['confirmed', 'ongoing']);
                });
            }])
            ->orderBy('active_orders', 'desc')
            ->take(5)
            ->get();

        return [
            'cards' => [
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_users' => $totalUsers,
                'active_rentals' => $activeRentals,
                'pending_payments' => $pendingPayments,
            ],
            'charts' => [
                'monthly_revenue' => $monthlyRevenue,
                'order_status' => $orderStatus,
                'payment_methods' => $paymentMethods,
                'daily_orders' => $dailyOrders,
            ],
            'tables' => [
                'recent_orders' => $recentOrders,
                'top_products' => $topProducts,
                'active_rentals' => $activeRentals,
            ]
        ];
    }

    /**
     * Get dashboard data for rental users
     */
    private function getRentalDashboardData()
    {
        $userId = Auth::id();

        // Statistics Cards
        $totalProducts = Product::where('user_id', $userId)->count();
        $totalOrders = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $totalRevenue = Payment::whereHas('order.product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'success')->sum('gross_amount');

        $activeRentals = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'ongoing')->count();

        $pendingOrders = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $availableProducts = Product::where('user_id', $userId)->where('is_available', true)->count();

        // Monthly Revenue Chart Data
        $monthlyRevenue = Payment::whereHas('order.product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'success')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(gross_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create()->month($item->month)->format('M') => $item->total];
            });

        // Product Performance
        $productPerformance = Product::where('user_id', $userId)
            ->withCount(['orders as total_bookings'])
            ->withSum(['orders as total_revenue' => function ($query) {
                $query->whereHas('payment', function ($q) {
                    $q->where('status', 'success');
                });
            }], 'total_harga')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Recent Orders
        $recentOrders = Order::with(['user', 'product', 'payment'])
            ->whereHas('product', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->take(10)
            ->get();

        // Order Status Distribution
        $orderStatus = Order::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        // Most Popular Products
        $popularProducts = Product::where('user_id', $userId)
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return [
            'cards' => [
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'active_rentals' => $activeRentals,
                'pending_orders' => $pendingOrders,
                'available_products' => $availableProducts,
            ],
            'charts' => [
                'monthly_revenue' => $monthlyRevenue,
                'order_status' => $orderStatus,
            ],
            'tables' => [
                'recent_orders' => $recentOrders,
                'product_performance' => $productPerformance,
                'popular_products' => $popularProducts,
            ]
        ];
    }

    /**
     * Get dashboard data for customer users
     */
    private function getCustomerDashboardData()
    {
        $userId = Auth::id();

        // Statistics Cards
        $totalOrders = Order::where('user_id', $userId)->count();
        $totalSpent = Payment::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'success')->sum('gross_amount');

        $activeRentals = Order::where('user_id', $userId)->where('status', 'ongoing')->count();
        $completedRentals = Order::where('user_id', $userId)->where('status', 'completed')->count();
        $pendingPayments = Payment::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending')->count();

        // Recent Orders
        $recentOrders = Order::with(['product', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        // Order Status Distribution
        $orderStatus = Order::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        // Monthly Spending Chart Data
        $monthlySpending = Payment::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'success')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(gross_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create()->month($item->month)->format('M') => $item->total];
            });

        // Favorite Products (most rented)
        $favoriteProducts = Product::whereHas('orders', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->withCount(['orders as rental_count' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->orderBy('rental_count', 'desc')
            ->take(5)
            ->get();

        return [
            'cards' => [
                'total_orders' => $totalOrders,
                'total_spent' => $totalSpent,
                'active_rentals' => $activeRentals,
                'completed_rentals' => $completedRentals,
                'pending_payments' => $pendingPayments,
            ],
            'charts' => [
                'monthly_spending' => $monthlySpending,
                'order_status' => $orderStatus,
            ],
            'tables' => [
                'recent_orders' => $recentOrders,
                'favorite_products' => $favoriteProducts,
            ]
        ];
    }

    /**
     * Get real-time dashboard stats (for AJAX requests)
     */
    public function getStats()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $stats = [
                'total_orders_today' => Order::whereDate('created_at', today())->count(),
                'total_revenue_today' => Payment::where('status', 'success')
                    ->whereDate('created_at', today())->sum('gross_amount'),
                'pending_payments' => Payment::where('status', 'pending')->count(),
                'active_rentals' => Order::where('status', 'ongoing')->count(),
            ];
        } elseif ($user->isRental()) {
            $stats = [
                'orders_today' => Order::whereHas('product', function ($query) {
                    $query->where('user_id', Auth::id());
                })->whereDate('created_at', today())->count(),
                'revenue_today' => Payment::whereHas('order.product', function ($query) {
                    $query->where('user_id', Auth::id());
                })->where('status', 'success')->whereDate('created_at', today())->sum('gross_amount'),
                'pending_orders' => Order::whereHas('product', function ($query) {
                    $query->where('user_id', Auth::id());
                })->where('status', 'pending')->count(),
            ];
        } else {
            $stats = [
                'active_rentals' => Order::where('user_id', Auth::id())->where('status', 'ongoing')->count(),
                'pending_payments' => Payment::whereHas('order', function ($query) {
                    $query->where('user_id', Auth::id());
                })->where('status', 'pending')->count(),
            ];
        }

        return response()->json($stats);
    }
}
