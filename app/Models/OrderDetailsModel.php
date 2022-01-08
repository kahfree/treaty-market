<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model {
    protected $builder;
    protected $table = 'orderdetails';
    protected $primaryKey = 'orderNumber';
    protected $allowedFields = ['orderNumber','produceCode','quantityOrdered','priceEach'];
    protected $useAutoIncrement = false;

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

    //This method gets all rows that contain an order number
    public function getAllProductsOnOrder($orderNumber)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['orderNumber' => $orderNumber])->getResult();
        return $query;
    }

    public function getProduceCodeArray($orderNumber)
    {
        $products = [];
        foreach($this->getAllProductsOnOrder($orderNumber) as $row){
            array_push($products,$row->produceCode);
        }
        return $products;
    }

    public function removeProductFromOrder($orderNumber,$produceCode)
    {
        $builder = $this->builder();
        $array = ['orderNumber'=>$orderNumber,'produceCode' => $produceCode];
        $query = $builder->where($array)->delete();
    }


}