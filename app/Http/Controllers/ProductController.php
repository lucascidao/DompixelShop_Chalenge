<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function register(Request $request)
    {
        try{
            $this->productService->register($request);
            return response()->json('Product saved!', 200);
        }catch(Exception $e){
            return response()->json('Error while saving the product'); 
        }
        

    }
    public function update(Request $request, $id){
        try{
        $this->productService->update($request,$id);
        return response()->json('Product updated!', 200);
        }catch(Exception $e){
            return response()->json('Error while updating product');
        }
    }
    public function delete($id){
        try{
            $this->productService->delete($id);
        }catch(Exception $e){
            return response()->json('Error while deleting product');
        }
    }
    public function list(){
        try{
            return $this->productService->list();
        }catch(Exception $e){
            return response()->json('Error while listing all the product');
        }
    }
    public function show($id){
        try{
            return $this->productService->show($id);
        }catch(Exception $e){
            return response()->json("Error while finding the product");
        }
    }
}
