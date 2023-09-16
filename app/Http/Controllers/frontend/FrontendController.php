<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function getAllProduct()
    {
        try {

            $allProduct = Product::where('status','1')
                ->get();

            $allData = [];
            foreach ($allProduct as $index=>$item){

                // Calculate the discount amount
                $discountAmount = ($item->discount / 100) * $item->price;
                // Calculate the discounted price
                $discountedPrice = $item->price - $discountAmount;

                $singleData = [
                    'id'=>$item->id,
                    'product_name'=>$item->product_name,
                    'product_code'=>$item->product_code,
                    'product_slug'=>$item->product_slug,
                    'regular_price'=>$item->price,
                    'save_amount'=>(int)round($discountAmount),
                    'discount_price'=>(int)round($discountedPrice),
                    'discount'=>$item->discount.'%',
                    'product_image'=>$item->product_image
                ];
                array_push($allData,$singleData);
            }

            if (count($allProduct) > 0){
                return apiResponse($allData);
            }
            return apiResponse(null,'Data not found',404);

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function singleProduct($id,$slug)
    {
        try {
            $product = Product::where('id',$id)->where('product_slug', $slug)->first();

            // Calculate the discount amount
            $discountAmount = ($product->discount / 100) * $product->price;
            // Calculate the discounted price
            $discountedPrice = $product->price - $discountAmount;
            $color = explode(',',$product->size);
            $size = explode(',',$product->color);

            $data = [
                'id'=>$product->id,
                'product_name'=>$product->product_name,
                'product_code'=>$product->product_code,
                'product_slug'=>$product->product_slug,
                'regular_price'=>$product->price,
                'save_amount'=>(int)round($discountAmount),
                'discount_price'=>(int)round($discountedPrice),
                'discount'=>$product->discount.'%',
                'color'=>$color,
                'size'=>$size,
                'qty'=>$product->qty,
                'product_image'=>$product->product_image,
                'short_desc'=>$product->short_desc,
                'long_desc'=>$product->long_desc,
            ];

            if ($product != null){
                return apiResponse($data);
            }
            return apiResponse(null,'Data not found',404);

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }
}
