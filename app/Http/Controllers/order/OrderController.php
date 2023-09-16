<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function customerOrderList()
    {
        try {
            $customer = Auth::id();
            $orders = Order::where('customer_id',$customer)->get();

            if (count($orders) > 0){
                return  apiResponse($orders);
            }
            else{
                return apiResponse(null, 'No product order yet');
            }
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function storeOrder(Request $request)
    {
        try {
            $customer = Auth::id();
            $carts = Cart::where('customer_id',$customer)->get();
            Order::placeOrder($request,$carts);
            return apiResponse(null,'Order place successfully');

        }
        catch (Exception $e){
            return apiError($e->getMessage());
        }
    }
}
