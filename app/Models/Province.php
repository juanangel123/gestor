<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * @package App\Models
 */
class Province extends Model
{

    /**
     * @var string
     */
    protected $table = 'province';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }
}
