<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model {
    protected $builder;
    protected $table = 'orders';
    protected $primaryKey = 'orderNumber';
    protected $allowedFields = ['orderNumber','orderDate','requiredDate','shippedDate','status','comments','customerNumber'];
    protected $useAutoIncrement = TRUE;

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

    //This method gets a order from the orders table by the order number
    public function getOrder($orderNumber)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['orderNumber' => $orderNumber])->getResult();
        return $query[0];
    }
    //This method gets all orders tied to a customer by their customer ID
    public function getAllCustomerOrders($customerNumber)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['customerNumber' => $customerNumber])->getResult();
        return $query;
    }

    public function getOrderCount($customerNumber)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['customerNumber' => $customerNumber])->getResult();
        return count($query);
    }

    public function countForShippingType($customerNumber, $shippingType)
    {
        $builder = $this->builder();
        $constraints = ['customerNumber' => $customerNumber, 'status' => $shippingType];
        $query = $builder->getWhere($constraints)->getResult();
        return count($query);
    }

    public function getLargestOrderNumber(){
        $builder = $this->builder();
        $query = $builder->orderBy('orderNumber', 'DESC')->limit(1);
        return $query->get()->getResult()[0];
    }
}