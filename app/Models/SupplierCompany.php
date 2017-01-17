<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SupplierCompany
 * @package App\Models
 */
class SupplierCompany extends Model
{
    /**
     * @var string
     */
    protected $table = 'supplier_company';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Returns the name
     *
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }


    /**
     * Returns the address
     *
     * @return mixed
     */
    public function getAddress() {
        return $this->hasOne('App\Models\Address', 'id', 'address_id')->getResults();
    }


    /**
     * @return mixed
     */
    public function __toString() {
        return $this->getName();
    }
}
