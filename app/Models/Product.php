<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded =[];

    public static function saveProduct($request,$imagePath)
    {
        $productSlug = Str::slug($request->productName,'-');
        $productCode = 'P'.rand(10000,99999);

        $product = new Product();
        $product->product_name= $request->productName;
        $product->product_slug= $productSlug;
        $product->product_code= $productCode;
        $product->color= $request->color;
        $product->size= $request->size;
        $product->price= $request->price;
        $product->qty= $request->qty;
        $product->discount= $request->discount;
        $product->product_image= $imagePath;
        $product->short_desc= $request->shortDesc;
        $product->long_desc= $request->longDesc;
        $product->status= $request->status;

        $product->save();

    }
    public static function updateProduct($request,$imagePath,$id)
    {
        $productSlug = Str::slug($request->productName,'-');

        $product = Product::findOrFail($id);

        $product->product_name= $request->productName;
        $product->product_slug= $productSlug;
        $product->color= $request->color;
        $product->size= $request->size;
        $product->price= $request->price;
        $product->qty= $request->qty;
        $product->discount= $request->discount;
        $product->product_image= $imagePath;
        $product->short_desc= $request->shortDesc;
        $product->long_desc= $request->longDesc;
        $product->status= $request->status;

        $product->save();

    }
}
