@extends('layouts.main')

@section('title', 'My Orders')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-6">My Orders</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($orders as $order)
                        <div class="border-b last:border-b-0 py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-bold text-lg">Order #{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold">Rp {{ number_format($order->total_amount) }}</div>
                                    <span @class([
                                        'text-sm px-2 py-1 rounded-full',
                                        'bg-yellow-200 text-yellow-800' => $order->status == 'pending',
                                        'bg-blue-200 text-blue-800' => $order->status == 'paid',
                                        'bg-green-200 text-green-800' => $order->status == 'shipped',
                                        'bg-red-200 text-red-800' => $order->status == 'cancelled',
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 border-t pt-4">
                                <h4 class="font-semibold text-sm text-gray-600 mb-2">Items:</h4>
                                <ul class="list-disc list-inside text-sm text-gray-800">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="text-right mt-4 flex items-center justify-end space-x-4">
                                <a href="{{ route('orders.show', $order) }}"
                                    class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-xs font-semibold hover:bg-gray-300">
                                    Lihat Detail
                                </a>

                                @if ($order->status === 'pending')
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md text-xs font-semibold hover:bg-red-600">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>You have no orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
