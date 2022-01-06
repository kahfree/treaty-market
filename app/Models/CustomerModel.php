<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model {
    protected $builder;
    protected $table = 'customers';
    protected $primaryKey = 'customerNumber';
    protected $allowedFields = ['customerNumber','customerName','contactLastName','contactFirstName','phone','addressLine1','addressLine2','city','postalCode','country','creditLimit','email','password'];
    

    protected $useAutoIncrement = TRUE;

    

    public function getCustomers()
    {
        $builder = $this->builder();
        $query = $builder->get();
        return $query;
    }

    //This method gets the customer from the table using their email
    public function getCustomerByEmail($customerEmail){
        $builder = $this->builder();
        $query = $builder->getWhere(['email' => $customerEmail])->getFirstRow();
            return $query;
    }

    //This method gets the customer from the table using their ID
    public function getCustomerByID($customerID)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['customerNumber' => $customerID])->getFirstRow();
            return $query;
    }

    //This method checks if the user's credentials matches any row in the customer table
    public function validateCustomerLogin($email,$password){
        $customer = $this->getCustomerByEmail($email);
        if($customer){
            print_r($customer);
            print_r(hash('md5',$password));
        if($email === $customer->email && hash('md5',$password) === $customer->password)
            return true;

        }
        return false;
        
    }
}