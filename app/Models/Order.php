<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function placeOrder($request,$carts)
    {
        foreach ($carts as $index=>$item){
            $invoiceNo = 'INV_'.rand(1000000,9999999);
            $txnId = 'TRX_'.rand(10000000,99999999);

            $insertOrder = Order::insert([
               'invoice_no'=> $invoiceNo,
               'customer_id'=> $item->customer_id,
               'txn_id'=> $txnId,
               'product_code'=> $item->product_code,
               'size'=> $item->size,
               'color'=> $item->color,
               'quantity'=> $item->quantity,
               'unit_price'=> $item->unit_price,
               'total_price'=> $item->total_price,
               'payment_method'=> $request->payment_method,
               'delivery_address'=> $request->delivery_address,
               'order_status'=> 'pending',
            ]);

            if ($insertOrder > 0){
                Cart::where('id',$item->id)->delete();
            }
        }
    }
}
