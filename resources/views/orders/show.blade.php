@extends('layouts.main')

@section('title', 'Order Details #' . $order->id)

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Order Details</h2>
                        @if ($order->status === 'paid' || $order->status === 'shipped')
                            <a href="{{ route('orders.downloadInvoice', $order) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">
                                Download Invoice (PDF)
                            </a>
                        @else
                            <div class="p-2 bg-yellow-100 text-yellow-800 text-sm rounded-md">
                                Anda dapat mengunduh invoice setelah pembayaran dikonfirmasi.
                            </div>
                        @endif
                    </div>

                    <div class="invoice-box"
                        style="border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); padding: 30px; font-family: 'Helvetica Neue', sans-serif; font-size: 14px; color: #555;">
                        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p><strong>Total:</strong> Rp {{ number_format($order->total_amount) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <h4 class="font-bold mt-6 mb-2 text-lg">Items Ordered:</h4>
                        <div class="border-t border-b border-gray-200">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between items-center py-4 border-b last:border-b-0">
                                    <div>
                                        <p class="font-semibold">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $item->quantity }} x Rp {{ number_format($item->price) }}
                                        </p>
                                    </div>
                                    <p class="font-semibold text-gray-800">
                                        Rp {{ number_format($item->price * $item->quantity) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end mt-4">
                            <div class="w-full md:w-1/3">
                                <div class="flex justify-between text-lg">
                                    <span class="font-semibold text-gray-800">Total:</span>
                                    <span class="font-bold text-gray-900">Rp
                                        {{ number_format($order->total_amount) }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
