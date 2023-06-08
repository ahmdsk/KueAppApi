<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::orderBy('id')->get();

        if (count($store) > 0) {
            return response()->json([
                'message'   => 'Success Get All Store',
                'data'      => $store
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Store Not Found',
                'data'      => []
            ], 404);
        }
    }

    public function create(Request $request) {
        $req_store = $request->only(['store_name', 'store_location']);

        $validator = Validator::make($req_store, [
            'store_name'        => 'required|string',
            'store_location'    => 'required|string'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $store = Store::create($req_store);
        if($store) {
            return response()->json([
                'message'   => 'Success Create Store',
                'data'      => $store
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Failed Create Store',
                'data'      => null
            ], 400);
        }
    }

    public function update(Request $request) {
        $req_store = $request->only(['store_name', 'store_location']);

        $validator = Validator::make($req_store, [
            'store_name'        => 'required|string',
            'store_location'    => 'required|string'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $store = Store::where('id', $request->id)->update($req_store);

        if($store) {
            return response()->json([
                'message'   => 'Success Update Store',
                'data'      => $req_store
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Failed Update Store',
                'data'      => null
            ], 400);
        }
    }

    public function delete(Request $request) {
        $store = Store::find($request->id);

        if($store) {
            $store->delete();

            return response()->json([
                'message'   => 'Success Delete Store',
                'data'      => $store
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Failed Delete Store',
                'data'      => null
            ], 400);
        }
    }
}
