<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
        $data = $request->all();
        $this->productRepository->save($data);
    }

    public function update(Request $request,$id)
    {
        $this->productRepository->update($request->all(), $id);
    }

    public function delete($id){
        $this->productRepository->delete($id);
    }
    public function list(){
        return $this->productRepository->list();
    }
    public function show($id){
        return $this->productRepository->show($id);
    }
}
