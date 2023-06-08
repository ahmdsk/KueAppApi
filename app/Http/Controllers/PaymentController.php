<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index() {
        $payment = Payment::orderBy('id')->get();

        if(count($payment) > 0) {
            return response()->json([
                'message' => 'Success Get Payment',
                'data' => $payment
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed Get Payment',
                'data' => []
            ], 400);
        }
    }

    public function create(Request $request) {
        $req_payment = $request->only(['payment_method', 'payment_logo']);

        $validator = Validator::make($req_payment, [
            'payment_method'    => 'required',
            'payment_logo'      => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image is exist
        if($request->hasFile('payment_logo')) {
            $payment_logo = $request->file('payment_logo');
            $payment_logo_extension = $payment_logo->getClientOriginalExtension();
            $payment_logo_name = time() . '.' . $payment_logo_extension;
            $payment_logo->move('images/payment', $payment_logo_name);
            $req_payment['payment_logo'] = $payment_logo_name;
        }

        $create_payment = Payment::create($req_payment);
        if($create_payment) {
            return response()->json([
                'message' => 'Success Create Payment',
                'data' => $create_payment
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Create Payment',
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request) {
        $req_payment = $request->only(['payment_method', 'payment_logo']);

        $validator = Validator::make($req_payment, [
            'payment_method'    => 'required',
            'payment_logo'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image is exist
        if($request->hasFile('payment_logo')) {
            $payment_logo = $request->file('payment_logo');
            $payment_logo_extension = $payment_logo->getClientOriginalExtension();
            $payment_logo_name = time() . '.' . $payment_logo_extension;
            $payment_logo->move('images/payment', $payment_logo_name);
            $req_payment['payment_logo'] = $payment_logo_name;
        }

        $update_payment = Payment::where('id', $request->id)->update($req_payment);
        if($update_payment) {
            return response()->json([
                'message' => 'Success Update Payment',
                'data' => $req_payment
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Update Payment',
                'data' => []
            ], 400);
        }
    }

    public function delete(Request $request) {
        $delete_payment = Payment::find($request->id);
        if($delete_payment) {
            $delete_payment->delete();

            return response()->json([
                'message' => 'Success Delete Payment',
                'data' => $delete_payment
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Delete Payment',
                'data' => []
            ], 400);
        }
    }
}
