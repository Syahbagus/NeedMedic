<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $orders = $user->orders()->latest()->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Membatalkan pesanan.
     */
    public function cancel(Order $order)
    {
        // Keamanan: Pastikan pengguna hanya bisa membatalkan pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya pesanan dengan status 'pending' yang bisa dibatalkan
        if ($order->status === 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('orders.index')->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }
}
