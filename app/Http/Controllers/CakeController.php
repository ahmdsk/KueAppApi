<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CakeController extends Controller
{
    public function index() {
        $cakes = Cake::orderBy('id')->get();
        
        if(count($cakes) > 0) {
            return response()->json([
                'message' => 'Success Get All Cake',
                'data' => $cakes
            ], 200);
        } else {
            return response()->json([
                'message' => 'Cake Not Found',
                'data' => []
            ], 404);
        }
    }

    public function show(Request $request) {
        $cake = Cake::where('id', $request->id)->first();

        if($cake) {
            return response()->json([
                'message'   => 'Success Get Cake',
                'data'      => $cake
            ], 200);
        } else {
            return response()->json([
                'message'   => 'Cake Not Found',
                'data'      => null
            ], 404);
        }
    }

    public function create(Request $request) {
        $req_cake = $request->only(['cake_name', 'cake_image', 'cake_price', 'description', 'cake_width', 'cake_height', 'cake_id']);

        $validator = Validator::make($req_cake, [
            'cake_name'     => 'required|string',
            'cake_image'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cake_price'    => 'required|integer',
            'cake_id'       => 'required|integer'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('cake_image')) {
            $image = $request->file('cake_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/cake');
            $image->move($destinationPath, $name);

            $req_cake['cake_image'] = $name;
        }

        $create_cake = Cake::create($req_cake);
        if($create_cake) {
            return response()->json([
                'message' => 'Success Create New Cake',
                'data' => $create_cake
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Create New Cake',
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request) {
        $req_cake = $request->only(['cake_name', 'cake_image', 'cake_price', 'description', 'cake_width', 'cake_height', 'cake_id']);

        $validator = Validator::make($req_cake, [
            'cake_name'     => 'required|string',
            'cake_image'    => 'image|mimes:jpeg,png,jpg|max:2048',
            'cake_price'    => 'required|integer',
            'cake_id'       => 'required|integer'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('cake_image')) {
            $image = $request->file('cake_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/cake');
            $image->move($destinationPath, $name);

            $req_cake['cake_image'] = $name;
        }

        $update_cake = Cake::where('id', $request->id)->update($req_cake);
        if($update_cake) {
            return response()->json([
                'message' => 'Success Update Cake',
                'data' => $req_cake
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Update Cake',
                'data' => []
            ], 400);
        }
    }

    public function delete(Request $request) {
        $delete_cake = Cake::find($request->id);

        if($delete_cake) {
            $delete_cake->delete();

            return response()->json([
                'message' => 'Success Delete Cake',
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Delete Cake',
            ], 400);
        }
    }
}
