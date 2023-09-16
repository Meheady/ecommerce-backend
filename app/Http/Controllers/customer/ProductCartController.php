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
            $cart = Cart::where('product_code', $request->product_code)->first();

            $unitPrice = $request->unit_price;

            if ($cart != null) {
                // If the cart item already exists, increment the quantity and update the total price
                $quantity = $cart->quantity + $request->quantity;
                $totalPrice = $unitPrice * $quantity;

                $cart->update([
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                ]);
            } else {
                // If the cart item doesn't exist, create a new one
                $payload = [
                    'customer_id' => $customer,
                    'product_name' => $request->product_name,
                    'product_code' => $request->product_code,
                    'product_image' => $request->product_image,
                    'size' => $request->size,
                    'color' => $request->color,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'total_price' => $unitPrice * $request->quantity,
                ];

                Cart::create($payload);

            }

            return apiResponse(null, 'Successfully added to cart');


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


    public function removeCartList($product_code){

        try {
            $result = Cart::where('product_code',$product_code)->delete();
            return apiResponse(null,'Product remove from cart');
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }

    }


    public function cartItemPlus($product_code){

        try {
            $customer = Auth::id();
            $cart = Cart::where('product_code', $product_code)->first();

            $unitPrice = $cart->unit_price;

            if ($cart != null) {
                // If the cart item already exists, increment the quantity and update the total price
                $quantity = $cart->quantity + 1;
                $totalPrice = $unitPrice * $quantity;

                $cart->update([
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                ]);
            }
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }


    }

    public function cartItemMinus($product_code){
        try {
            $customer = Auth::id();
            $cart = Cart::where('product_code', $product_code)->first();

            $unitPrice = $cart->unit_price;

            if ($cart != null) {
                // If the cart item already exists, increment the quantity and update the total price
                $quantity = $cart->quantity - 1;
                $totalPrice = $unitPrice * $quantity;

                $cart->update([
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                ]);
            }
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }

    }
}
