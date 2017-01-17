<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PowerContracted
 * @package App\Models
 */
class PowerContracted extends Model
{
    /**
     * @var string
     */
    protected $table = 'power_contracted';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the total power contracted
     *
     * @return mixed
     */
    public function getTotal() {
        return $this->total;
    }


    /**
     * Returns the contract associated
     *
     * @return mixed
     */
    public function getContract() {
        return $this->hasOne('App\Models\Contract', 'id', 'contract_id')->getResults();
    }
}
