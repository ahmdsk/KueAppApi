<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index() {
        $cakes = Categories::orderBy('id')->get();
        
        if(count($cakes) > 0) {
            return response()->json([
                'message' => 'Success Get All Categories Cake',
                'data' => $cakes
            ], 200);
        } else {
            return response()->json([
                'message' => 'Categories Cake Not Found',
                'data' => []
            ], 404);
        }
    }

    public function create(Request $request) {
        $req_category = $request->only(['category_name', 'category_image']);

        $validator = Validator::make($req_category, [
            'category_name' => 'required|string',
            'category_image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/categories');
            $image->move($destinationPath, $name);

            $req_category['category_image'] = $name;
        }

        $create_category = Categories::create($req_category);
        if($create_category) {
            return response()->json([
                'message' => 'Success Create Category Cake',
                'data' => $create_category
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Create Category Cake',
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request) {
        $req_category = $request->only(['category_name', 'category_image']);

        $validator = Validator::make($req_category, [
            'category_name' => 'required|string',
            'category_image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // if image exists
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/categories');
            $image->move($destinationPath, $name);

            $req_category['category_image'] = $name;
        }

        $update_category = Categories::where('id', $request->id)->update($req_category);
        if($update_category) {
            return response()->json([
                'message' => 'Success Update Category Cake',
                'data' => $req_category
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Update Category Cake',
                'data' => []
            ], 400);
        }
    }

    public function delete(Request $request) {
        $delete_category = Categories::find($request->id);

        if($delete_category) {
            $delete_category->delete();

            return response()->json([
                'message' => 'Success Delete Category Cake',
                'data' => $delete_category
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed Delete Category Cake',
                'data' => []
            ], 400);
        }
    }
}
