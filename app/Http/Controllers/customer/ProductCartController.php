<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCartController extends Controller
{

    public function customerCartList()
    {
        try {
            $customer = Auth::id();
            $carts = Cart::where('customer_id',$customer)->get();

            if (count($carts) > 0){
                return  apiResponse($carts);
            }
            else{
                return apiResponse(null, 'Cart is empty');
            }
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function storeCart(Request $request)
    {
        try {
            $customer = Auth::id();
            $cart = Cart::where('product_code',$request->product_code)->first();
            $quantity = $request->qty;
            $unitPrice = $request->discount_price;
            if ($cart != null){
                $quantity = $cart->quantity + 1;
                $totalPrice = $unitPrice * $quantity;
            }


        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function updateCart()
    {
        try {

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }
}
