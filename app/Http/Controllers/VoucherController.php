<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('id')->get();

        if (count($vouchers) > 0) {
            return response()->json([
                'message' => 'Success Get All Voucher',
                'data' => $vouchers
            ], 200);
        } else {
            return response()->json([
                'message' => 'Voucher Not Found',
                'data' => []
            ], 404);
        }
    }

    public function show(Request $request)
    {
        $voucher = Voucher::where('id', $request->id)->first();

        if ($voucher) {
            return response()->json([
                'message'   => 'Success Get Voucher',
                'data'      => $voucher
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Voucher Not Found',
                'data'      => null
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $req_voucher = $request->only(['voucher_code', 'voucher_name', 'voucher_image']);

        $validator = Validator::make($req_voucher, [
            'voucher_code'     => 'required|string',
            'voucher_name'     => 'required|string',
            'voucher_image'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('voucher_image')) {
            $image = $request->file('voucher_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/voucher');
            $image->move($destinationPath, $name);

            $req_voucher['voucher_image'] = $name;
        }

        $voucher = Voucher::create($req_voucher);

        if ($voucher) {
            return response()->json([
                'message'   => 'Success Create Voucher',
                'data'      => $voucher
            ], 201);
        } else {
            return response()->json([
                'message'   => 'Failed Create Voucher',
                'data'      => null
            ], 400);
        }
    }

    public function update(Request $request) {
        $req_voucher = $request->only(['voucher_code', 'voucher_name', 'voucher_image']);

        $validator = Validator::make($req_voucher, [
            'voucher_code'     => 'required|string',
            'voucher_name'     => 'required|string',
            'voucher_image'    => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('voucher_image')) {
            $image = $request->file('voucher_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/voucher');
            $image->move($destinationPath, $name);

            $req_voucher['voucher_image'] = $name;
        }

        $voucher = Voucher::where('id', $request->id)->update($req_voucher);

        if ($voucher) {
            return response()->json([
                'message'   => 'Success Update Voucher',
                'data'      => $req_voucher
            ], 201);
        } else {
            return response()->json([
                'message'   => 'Failed Update Voucher',
                'data'      => null
            ], 400);
        }
    }

    public function delete(Request $request) {
        $voucher = Voucher::find($request->id);

        if ($voucher) {
            $voucher->delete();

            return response()->json([
                'message'   => 'Success Delete Voucher',
                'data'      => $voucher
            ], 201);
        } else {
            return response()->json([
                'message'   => 'Failed Delete Voucher',
                'data'      => null
            ], 400);
        }
    }
}
