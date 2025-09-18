@extends('layouts.main')

@section('title', $product->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div>
                            @if ($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                    class="w-full h-auto object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h1 class="text-4xl font-bold mb-2">{{ $product->name }}</h1>
                            <p class="text-sm text-gray-500 mb-4">
                                Category: <a href="{{ route('categories.show', $product->category) }}"
                                    class="text-blue-600 hover:underline">{{ $product->category->name }}</a>
                            </p>

                            <p class="text-3xl font-semibold text-blue-600 mb-6">
                                Rp {{ number_format($product->price) }}
                            </p>

                            <div class="prose max-w-none mb-6">
                                {!! $product->description !!}
                            </div>

                            <p class="text-sm text-gray-600 mb-4">
                                Stock: <span class="font-medium">{{ $product->stock }}</span>
                            </p>

                            @if ($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 text-lg">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <div class="mt-6">
                                    <button
                                        class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed"
                                        disabled>
                                        Out of Stock
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
