<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use DB;

use Exception;

class OrderController extends Controller
{
    // Using this function return orders
    public function orders(Request $request)
    {
        try{
            $orders = Order::with('order_items')->orderBy('created_at','desc')->get();
            return response()->json($orders);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage(),'success'=>false],500);
        }
    }

    // Using this function placed order
    public function orderPlaced(Request $request)
    {
        DB::beginTransaction();
        try{
            $order = new Order;
            $order->order_id = '#ORD' . rand(10, 99) . time();
            $order->amount = $request->totalAmount;
            $order->save();

            foreach ($request->products as $product) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product['id'];
                $orderItem->qty = $product['qty'];
                $orderItem->price = $product['price'];
                $orderItem->total = $product['total'];
                $orderItem->save();
            }
            DB::commit();
            return response()->json(['message'=>'Order placed successfully!','success'=>true]);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['message'=>$e->getMessage(),'success'=>false],500);
        }
        
    }
    // Using this function update status of order
    public function orderStatusUpdate(Request $request)
    {
        try{    
            $order = Order::find($request->order_id);
            $order->status = $request->status;
            $order->save();
            return response()->json(['message'=>'Order status updated successfully!','success'=>true]);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage(),'success'=>false],500);
        }
    }
}
