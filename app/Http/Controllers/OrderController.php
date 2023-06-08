<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __invoke(Request $request)
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
        return $cake = Cake::find($req_order['cake_id']);

        $create_order = Order::create($req_order);
        if($create_order) {
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
}
