<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja dari database.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $cartItems = $user->cartItems()->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang di database.
     */
    public function add(Product $product, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();
        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus produk dari keranjang di database.
     */
    public function remove(Product $product)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->cartItems()->where('product_id', $product->id)->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
