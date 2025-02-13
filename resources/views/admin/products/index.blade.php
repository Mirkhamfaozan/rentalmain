@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-blue-600 font-bold text-3xl">Daftar Produk Motor</h2>
        <a href="{{ route('admin.products.create') }}"
            class="bg-red-600 text-white py-1 px-4 rounded-md hover:bg-red-700 transition duration-300 shadow-md">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-center border-collapse shadow-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3">Nama Motor</th>
                    <th class="px-6 py-3">CC Motor</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Transmisi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4">{{ $product->nama_motor }}</td>
                    <td class="px-6 py-4">{{ $product->cc_motor }} CC</td>
                    <td class="px-6 py-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ ucfirst($product->transmisi_motor) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="bg-red-600 text-white py-1 px-4 rounded-md hover:bg-red-700 transition duration-300 shadow-md">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white py-1 px-4 rounded-md hover:bg-red-700 transition duration-300 shadow-md"
                                    onclick="return confirm('Yakin hapus produk?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-gray-500 px-6 py-4">Belum ada produk yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection