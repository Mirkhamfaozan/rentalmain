@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-blue-600 font-bold text-2xl">Edit Produk Motor</h2>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Kembali ke Daftar Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="nama_motor" class="block text-sm font-semibold text-gray-700">Nama Motor</label>
                <input type="text" name="nama_motor" id="nama_motor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $product->nama_motor }}" required>
            </div>
            <div class="mb-4">
                <label for="cc_motor" class="block text-sm font-semibold text-gray-700">CC Motor</label>
                <input type="number" name="cc_motor" id="cc_motor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $product->cc_motor }}" required>
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-semibold text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $product->harga }}" required>
            </div>
            <div class="mb-4">
                <label for="transmisi_motor" class="block text-sm font-semibold text-gray-700">Transmisi</label>
                <select name="transmisi_motor" id="transmisi_motor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="manual" {{ $product->transmisi_motor == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="automatic" {{ $product->transmisi_motor == 'automatic' ? 'selected' : '' }}>Automatic</option>
                </select>
            </div>
            <div class="flex justify-end">
            <button type="submit" class="bg-red-600 text-white py-1 px-4 rounded-md hover:bg-red-700 transition duration-300 shadow-md">Update Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
