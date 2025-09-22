@extends('layouts.main')

@section('title', 'Shopping Cart')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <h2 class="text-3xl font-bold mb-6 border-b pb-4">Shopping Cart</h2>

                    @if ($cartItems->isNotEmpty())
                        @php $total = 0 @endphp

                        @foreach ($cartItems as $item)
                            @php $total += $item->product->price * $item->quantity @endphp
                            <div class="flex items-center border-b py-4" data-id="{{ $item->id }}">
                                <div class="w-1/4">
                                    @if ($item->product->image_url)
                                        <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                            alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">No Image
                                        </div>
                                    @endif
                                </div>
                                <div class="w-1/2 px-4">
                                    <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600">Rp {{ number_format($item->product->price) }}</p>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="w-1/4 text-right">
                                    <p class="font-semibold">Rp {{ number_format($item->product->price * $item->quantity) }}
                                    </p>
                                    <form action="{{ route('cart.remove', $item->product) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 text-right">
                            <p class="text-lg">Total: <span class="font-bold text-xl">Rp {{ number_format($total) }}</span>
                            </p>
                            <a href="{{ route('checkout.index') }}"
                                class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                                Proceed to Checkout
                            </a>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-xl text-gray-600">Your cart is empty.</p>
                            <a href="/" class="mt-4 inline-block text-blue-600 hover:underline">
                                Continue Shopping
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
