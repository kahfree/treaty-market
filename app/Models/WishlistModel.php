<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model {
    protected $builder;
    protected $table = 'wishlists';
    protected $primaryKey = 'wishlistID';
    protected $allowedFields = ['wishlistID','customerNumber','produceCode','comment','priority','quantity'];
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

    //This method gets a wishlist from tha wishlists table by the wishlist's ID
    public function getWishlist($customerNumber)
    {
        $builder = $this->builder();
        $query = $builder->getWhere(['customerNumber' => $customerNumber])->getResult();
        return $query;
    }


    public function removeWishlistItem($produceCode, $customerNumber)
    {
        $builder = $this->builder();
        $array = ['produceCode' => $produceCode, 'customerNumber' => $customerNumber];
        $query = $builder->where($array)->delete();
    }


}