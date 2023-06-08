<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        return $carts = Cart::where('user_id', Auth::user()->id)->orderBy('id')->get();
    }
}
