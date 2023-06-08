<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index() {
        $carts = Cart::where('user_id', Auth::guard('api')->user()->id)
            ->orderBy('id')
            ->with('cake', 'user')
            ->get();
        
        return response()->json([
            'message' => 'Success Get All Cart Data',
            'data' => $carts
        ]);
    }

    public function create(Request $request) {
        $req_cart = $request->only(['note', 'quantity', 'cake_id']);

        $validator = Validator::make($req_cart, [
            'quantity'  => 'required|integer',
            'cake_id'   => 'required|integer'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $req_cart['user_id'] = Auth::guard('api')->user()->id;
        $cart = Cart::create($req_cart);

        if($cart) {
            return response()->json([
                'message' => 'Success Create Cart Data',
                'data' => $cart
            ]);
        } else {
            return response()->json([
                'message' => 'Failed Create Cart Data',
                'data' => null
            ]);
        }
    }

    public function update_quantity(Request $request) {
        $req_cart = $request->only(['quantity', 'note', 'cart_id']);

        $validator = Validator::make($req_cart, [
            'quantity'  => 'required|integer',
            'cart_id'   => 'required|integer'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart = Cart::find($req_cart['cart_id'])->with('cake')->first();
        if($cart) {
            $cart->quantity = $req_cart['quantity'];
            $cart->note = $req_cart['note'];

            $cart->save();

            return response()->json([
                'message' => 'Success Update Cart Data',
                'data' => $cart
            ]);
        } else {
            return response()->json([
                'message' => 'Failed Update Cart Data',
                'data' => null
            ]);
        }
    }
}
