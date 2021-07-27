<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Auth;
use File;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function product(Request $request)
    {
        try {
            $product = new Product;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->status = 1;

            if (request()->hasFile('image')) {
                $image = $request->image;
                $fileName = time() . $image->getClientOriginalName();
                $image->move('./uploads/product/', $fileName);
                $product->image = $fileName;
            }
            $product->save();
            $success['message'] =  "Product added successfully.";
            $success['data'] =  $product;
            return response()->json($success);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function productList()
    {
        $product = Product::all();

        $success['message'] = "Product details fetch successfully.";
        $success['data'] = $product;
        return response()->json($success);
    }

    public function productDelete(Request $request)
    {
        $id = $request->id;
        $productDelete = Product::find($id);
        $image_path = "/uploads/product/" . $productDelete->image;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        Product::where('id', $id)->delete();
        $success['message'] =  "Product deleted successfully.";
        return response()->json($success);
    }

    public function productDetails(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        if ($product) {
            $success['message'] = "Product details fetch successfully.";
            $success['data'] = $product;
        } else {
            $success['message'] = "Product not found.";
            $success['data'] = null;
        }
        return response()->json($success);
    }

    public function updateProduct(Request $request)
    {
        try {
            $id = $request->id;
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->status = 1;

            if (request()->hasFile('image')) {
                $image = $request->image;
                $fileName = time() . $image->getClientOriginalName();
                $image->move('./uploads/product/', $fileName);
                $product->image = $fileName;
            }
            $product->save();
            $success['message'] =  "Product updated successfully.";
            $success['data'] =  $product;
            return response()->json($success);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $product = Product::where('name', 'LIKE', '%' . $name . '%')->get();

        if ($product) {
            $success['message'] =  "Product found successfully.";
            $success['data'] =  $product;
        } else {
            $success['message'] = "Product not found.";
            $success['data'] = null;
        }
        return response()->json($success);
    }
}
