<?php
namespace App\Repositories;

use App\Models\Product;
use Exception;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function list()
    {
        return $this->product->all();
    }
    public function show($id)
    {
        return $this->product->find($id);
    }

    public function save(array $data)
    {
        $this->product->fill($data);
        $this->product->save();
    }

    public function update(array $data, int $id)
    {
        $product = $this->product->find($id);
        if($product){
            return $product->update($data);
        }
        throw new Exception("Error Processing Request", 400);
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }
}
