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
        $cartItems = session()->get('cart', []);

        if (count($cartItems) == 0) {
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

        $cart = session()->get('cart', []);

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product->stock < $details['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok untuk produk ' . $product->name . ' tidak mencukupi.');
            }
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $totalAmount = 0;
            foreach ($cart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_bank' => $request->payment_bank,
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
                Product::find($id)->decrement('stock', $details['quantity']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Terima kasih! Pesanan Anda telah berhasil dibuat.');
    }
}
