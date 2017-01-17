<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Municipality
 * @package App\Models
 */
class Municipality extends Model
{

    /**
     * @var string
     */
    protected $table = 'municipality';


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
     * Returns the province
     *
     * @return Province
     */
    public function getProvince() {
        return $this->hasOne('App\Models\Province', 'id', 'province_id')->getResults();
    }


    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }
}
