<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::where('user_id', auth()->guard('api')->user()->id)
            ->with('user', 'cake', 'store', 'voucher', 'payment')
            ->get();

        if($order) {
            return response()->json([
                'message' => 'Success Get Order',
                'data' => $order
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed Get Order',
                'data' => []
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $req_order = $request->only(['quantity', 'cake_id', 'store_id', 'voucher_id', 'payment_id']);
        $req_order['user_id'] = auth()->guard('api')->user()->id;

        $validator = Validator::make($req_order, [
            'quantity'      => 'required',
            'cake_id'       => 'required',
            'store_id'      => 'required',
            'payment_id'    => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // get id cake
        $cake = Cake::find($req_order['cake_id']);
        if ($cake) {
            $req_order['price'] = $cake->cake_price * $req_order['quantity'];
        } else {
            return response()->json([
                'message' => 'Cake Not Found'
            ], 404);
        }

        $create_order = Order::create($req_order);
        if ($create_order) {
            return response()->json([
                'message' => 'Success Create Order',
                'data' => $create_order
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Create Order',
                'data' => []
            ], 400);
        }
    }

    public function update_status(Request $request) {
        $req_order = $request->only(['status', 'user_id']);

        $validator = Validator::make($req_order, [
            'status'    => 'required',
            'user_id'   => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::where('user_id', $request->user_id)
            ->where('id', $request->id)
            ->with('user', 'cake', 'store', 'voucher', 'payment')
            ->first();

        if ($order) {
            $order->status = $req_order['status'];
            $order->save();

            return response()->json([
                'message' => 'Success Update Order',
                'data' => $order
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed Update Order',
                'data' => []
            ], 400);
        }
    }
}
