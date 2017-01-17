<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 */
class Address extends Model
{

    /**
     * @var string
     */
    protected $table = 'address';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Returns the address line
     *
     * @return mixed
     */
    public function getLine() {
        return $this->line;
    }


    /**
     * Returns the post code
     *
     * @return mixed
     */
    public function getPostCode() {
        return $this->postcode;
    }


    /**
     * Returns the province
     *
     * @return Province
     */
    public function getProvince() {
        return $this->hasOne('App\Models\Province', 'id', 'province_id')->getResults();
    }


    /**
     * Returns the province
     *
     * @return Province
     */
    public function getLocality() {
        return $this->locality;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLine() . ($this->getLine() ? ", " : " ") . $this->getPostCode() . ($this->getPostCode() ? ", " : " ") . $this->getLocality() . ($this->getLocality() ? ", " : " ") . $this->getProvince();
    }
}
