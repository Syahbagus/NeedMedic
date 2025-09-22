<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $cartItems = Auth::user()->cartItems;

        if ($cartItems->isEmpty()) {
            return redirect('/')->with('warning', 'Your cart is empty. Please add products first.');
        }

        return view('checkout.index', compact('cartItems'));
    }

    /**
     * Memproses pesanan.
     */
    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cod,card,paypal',
            'payment_bank' => 'required_if:payment_method,card|string|nullable',
        ]);

        if ($request->payment_method === 'paypal' && !Auth::user()->paypal_id) {
            return redirect()->back()->withErrors(['payment_method' => 'Silakan tambahkan PayPal ID di profil Anda terlebih dahulu.']);
        }

        $cartItems = Auth::user()->cartItems;

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Stok untuk produk ' . $item->product->name . ' tidak mencukupi.');
            }
        }

        $order = DB::transaction(function () use ($request, $cartItems) {
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item->product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_bank' => $request->payment_bank,
            ]);

            // Buat record di tabel 'order_items' dan kurangi stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            return $order;
        });

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->cartItems()->delete();

        return redirect()->route('orders.index')->with('success', 'Terima kasih! Pesanan Anda telah berhasil dibuat.');
    }
}
