<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $orders = $user->orders()->with('items.product')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Membatalkan pesanan.
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('orders.index')->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }
    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Mengunduh invoice pesanan dalam format PDF.
     */
    public function downloadInvoice(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        if ($order->status !== 'paid' && $order->status !== 'shipped') {
            return redirect()->route('orders.show', $order)->with('error', 'Invoice hanya bisa diunduh setelah pembayaran dikonfirmasi.');
        }

        $pdf = Pdf::loadView('pdf.order_invoice', ['order' => $order]);
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
