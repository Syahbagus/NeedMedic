@extends('layouts.main')

@section('title', 'Welcome to NeedMedic')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full md:w-3/4">
                            <h2 class="text-2xl font-bold mb-6">All Products</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($products as $product)
                                    <div class="border rounded-lg overflow-hidden shadow-lg">

                                        @if ($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}"
                                                alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="bg-gray-200 h-48 w-full flex items-center justify-center">
                                                <span class="text-gray-500">No Image</span>
                                            </div>
                                        @endif

                                        <div class="p-4">
                                            <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>

                                            <p class="text-sm text-gray-600 mb-2">Stock: {{ $product->stock }}</p>

                                            <div class="flex justify-between items-center mt-4">
                                                <a href="#" class="text-sm font-medium text-indigo-600">View</a>

                                                @if ($product->stock > 0)
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 text-sm">
                                                            Buy
                                                        </button>
                                                    </form>
                                                @else
                                                    <button
                                                        class="bg-gray-400 text-white px-4 py-2 rounded-md text-sm cursor-not-allowed"
                                                        disabled>
                                                        Out of Stock
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                    <p class="col-span-3 text-center">No products found.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="w-full md:w-1/4">
                            <div class="border p-4 rounded-lg shadow-lg">
                                <h3 class="font-bold text-lg mb-4 border-b pb-2">Product Category</h3>
                                <ul>
                                    @forelse ($categories as $category)
                                        <li class="mb-2">
                                            <a href="{{ route('categories.show', $category) }}"
                                                class="text-gray-700 hover:text-indigo-600">{{ $category->name }}</a>
                                        </li>
                                    @empty
                                        <li>No categories found.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
