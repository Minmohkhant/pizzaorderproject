<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list
    public function pizzaList(Request $request){
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        }else{
            $data = Product::orderBy('created_at','asc')->get();
        }

        return response()->json($data, 200);
    }

    //return pizza cart
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            'message' => 'Add To Cart Complete',
            'status' => 'success'
        ];
        return response()->json($response, 200);
    }


    //order
    public function order(Request $request){
        $total = 0;
        $orderCode = "";
       foreach($request->all() as $item){
        $data = OrderList::create([
            'user_id' => $item['user_id'],
            'product_id' => $item['product_id'],
            'qty' => $item['qty'],
            'total' => $item['total'],
            'order_code' => $item['order_code'],
        ]);

        $total+= $data->total;
        $orderCode = $data->order_code;
       };
       logger($orderCode);

       Cart::where('user_id',Auth::user()->id)->delete();

       Order::create([
        'user_id' => Auth::user()->id,
        'order_code' => $orderCode,
        'total_price'=> $total+3000,
       ]);

       return response()->json([
        'status' => 'true',
        'message' => 'order completed'
        ], 200);
    }

    //clear cart
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    //clearCurrentProduct
    public function clearCurrentProduct(Request $request){
        Cart::where('user_id',Auth::user()->id)->where('id',$request->orderId)->where('product_id',$request->productId)->delete();
    }

    //increase viewCount
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->productId)->first();

        $viewCount = [
            'view_count' => $pizza->view_count + 1,
        ];

        Product::where('id',$request->productId)->update($viewCount);
    }

    //getOrderData
    private function getOrderData(Request $request){
        return  [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
