<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
class ProductController extends Controller
{
    // Using this function return products
    public function products(Request $request)
    {
        try{
            $products = Product::paginate(6);
            return response()->json($products);
        }catch(Exception $e){
            return response()->json(['message'=>'something went wrong! please try again!','success'=>false],500);
        }
    }
}
