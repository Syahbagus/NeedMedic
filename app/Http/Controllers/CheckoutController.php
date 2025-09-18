<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
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
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cod,card,paypal',
        ]);

        if ($request->payment_method === 'paypal' && !Auth::user()->paypal_id) {
            return redirect()->back()->withErrors(['payment_method' => 'Silakan tambahkan PayPal ID di profil Anda terlebih dahulu.']);
        }

        $cart = session()->get('cart', []);

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

            $totalAmount = 0;
            foreach ($cart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'status' => 'pending',
            ]);

            //Buat record di tabel 'order_items' dan kurangi stok
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

        // Kirim email konfirmasi dengan lampiran PDF
        // Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

        return redirect()->route('home')->with('success', 'Terima kasih! Pesanan Anda telah berhasil dibuat.');
    }
}
