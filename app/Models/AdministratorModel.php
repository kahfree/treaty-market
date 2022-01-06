<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministratorModel extends Model {
    protected $builder;
    protected $table = 'administrators';
    protected $primaryKey = 'adminNumber';
    protected $allowedFields = ['adminNumber','firstName','lastName','email','password'];
    protected $useAutoIncrement = TRUE;

    //This method gets the administrator from the table by email
    public function getAdministratorByEmail($email){
        $builder = $this->builder();
        $query = $builder->getWhere(['email' => $email])->getFirstRow();
        return $query;
    }

    //This method checks if the user's credentials match any row in the table
    public function validateAdminLogin($email,$password){
        $administrator = $this->getAdministratorByEmail($email);
        if($administrator){
        if($email === $administrator->email && hash('md5',$password) === $administrator->password)
            return true;
        }
        return false;
    }

}