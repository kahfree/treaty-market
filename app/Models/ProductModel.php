<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {
    protected $builder;
    protected $table = 'products';
    protected $primaryKey = 'produceCode';
    protected $allowedFields = ['produceCode','description','category','supplier','quantityInStock','bulkBuyPrice','bulkSalePrice','photo'];
    protected $useAutoIncrement = FALSE;

    public function getNumRows(){
        $builder = $this->builder();
        $query = $builder->countAllResults();
        return $query;
    }

    public function listAll(){
        $builder = $this->builder();
        $query = $builder->get();
        return $query;
    }

    //This method gets a product from the products table by the product's ID
    public function getProduct($produceCode)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['produceCode' => $produceCode])->getResult();
        return $query[0];
    }

    //Remove product?
    public function removeProduct($produceCode)
    {
        $builder = $this->builder();
        $query = $builder->where('produceCode', $produceCode)->delete();
    }

    public function searchProducts($key){
        $builder = $this->builder();
        if(!($key))
            $query = $builder->get();
        else
            $query = $builder->like('description',$key)->get();
        return $query;
    }


}