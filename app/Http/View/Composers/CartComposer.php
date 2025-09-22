<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    public function compose(View $view)
    {
        $cartCount = 0;
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $cartCount = $user->cartItems()->count();
        }

        $view->with('cartCount', $cartCount);
    }
}
