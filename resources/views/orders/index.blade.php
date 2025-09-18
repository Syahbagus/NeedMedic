@extends('layouts.main')

@section('title', 'My Orders')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-6">My Orders</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($orders as $order)
                        <div class="border-b py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-bold">Order #{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold">Rp {{ number_format($order->total_amount) }}</div>
                                    <span @class([
                                        'text-sm px-2 py-1 rounded-full', // Class yang selalu ada
                                        'bg-yellow-200 text-yellow-800' => $order->status == 'pending',
                                        'bg-blue-200 text-blue-800' => $order->status == 'paid',
                                        'bg-green-200 text-green-800' => $order->status == 'shipped',
                                        'bg-red-200 text-red-800' => $order->status == 'cancelled',
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            @if ($order->status === 'pending')
                                <div class="text-right mt-2">
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-red-500 hover:underline">Cancel
                                            Order</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>You have no orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
