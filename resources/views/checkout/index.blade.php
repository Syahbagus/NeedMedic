@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-6 text-center">Checkout</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-4">Shipping Information</h3>

                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700">Shipping
                                    Address</label>
                                <textarea name="shipping_address" id="shipping_address" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ auth()->user()->address }}</textarea>
                            </div>

                            <div x-data="{ paymentMethod: 'cod' }">
                                <h3 class="text-xl font-semibold mb-4 mt-6">Payment Method</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod">
                                        <span class="ms-3 text-sm font-medium">Bayar di Tempat (COD)</span>
                                    </label>
                                    <div class="border rounded-lg">
                                        <label class="flex items-center p-4 cursor-pointer">
                                            <input type="radio" name="payment_method" value="card"
                                                x-model="paymentMethod">
                                            <span class="ms-3 text-sm font-medium">Debit/Credit Card</span>
                                        </label>
                                        <div x-show="paymentMethod === 'card'" class="p-4 border-t" x-cloak>
                                            <label for="payment_bank" class="block text-sm font-medium text-gray-700">Pilih
                                                Bank</label>
                                            <select name="payment_bank" id="payment_bank"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="BCA">BCA</option>
                                                <option value="Mandiri">Bank Mandiri</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="CIMB">CIMB Niaga</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if (auth()->user()->paypal_id)
                                        <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                            <input type="radio" name="payment_method" value="paypal" class="h-4 w-4">
                                            <span class="ms-3 text-sm font-medium">
                                                Bayar dengan PayPal <br>
                                                <span class="text-xs text-gray-500">({{ auth()->user()->paypal_id }})</span>
                                            </span>
                                        </label>
                                    @else
                                        <div class="p-4 border rounded-lg bg-gray-50">
                                            <p class="text-sm text-gray-500">
                                                Tambahkan PayPal ID di halaman <a href="{{ route('profile.edit') }}"
                                                    class="underline text-blue-600">Profil</a> Anda untuk menggunakan metode
                                                ini.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                        @php $total = 0 @endphp
                        @foreach ($cartItems as $item)
                            @php $total += $item->product->price * $item->quantity @endphp
                            <div class="flex justify-between items-center border-b py-2">
                                <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                <span>Rp {{ number_format($item->product->price * $item->quantity) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center font-bold text-lg mt-4">
                            <span>Total</span>
                            <span>Rp {{ number_format($total) }}</span>
                        </div>
                        <button type="submit"
                            class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                            Place Order
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
