<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{


//    image upload method, get uploaded path
    public function getImagePath($image)
    {
        $imageExt = $image->getClientOriginalExtension();
        $imageName = time().'.'.$imageExt;
        $imageLocation = "assets/upload/product/";
        $image->move($imageLocation,$imageName);
        return $imageLocation.$imageName;
    }

    public function index()
    {
        try {

            $allProduct = Product::where('status','1')->get();

            if (count($allProduct) > 0){
                return apiResponse($allProduct);
            }
            return apiResponse(null,'Data not found',404);

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product != null){
                return apiResponse($product);
            }
            return apiResponse(null,'Data not found',404);

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = Validator::make($request->all(),[
            'productName' => 'required|string|max:255',
            'color' => 'string|max:255',
            'size' => 'string|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'discount' => 'numeric',
            'productImage' => 'image|max:2048', // Assuming you're uploading an image
            'shortDesc' => 'string',
            'longDesc' => 'string',
            'status' => 'numeric',
        ]);

        if ($validatedData->fails()){
            return apiError($validatedData->errors());
        }

        try {

            $imagePath = $this->getImagePath($request->file('productImage'));
           $savedProduct =  Product::saveProduct($request,$imagePath);
           return apiResponse(null, 'Product created successfully');
        }
        catch (Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {

            $requestId = $request->id;
            $product = Product::findOrFail($requestId);


            if ($request->hasFile('productImage')){

                if (file_exists($product->product_image)){
                    unlink($product->product_image);
                }
                $imagePath = $this->getImagePath($request->file('productImage'));
            }
            else{
                $imagePath  = $product->product_image;
            }

            $updatedProduct =  Product::updateProduct($request,$imagePath,$requestId);
            return apiResponse(null, 'Product updated successfully');
        }
        catch (Exception $e){
            return apiError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $product = Product::findOrFail($id);
            if (file_exists($product->product_image)){
                unlink($product->product_image);
                $productDelete = $product->delete();
                if ($productDelete != 1){
                    return apiError('Product not deleted');
                }
            }

        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }
}
