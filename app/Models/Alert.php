<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Alert
 * @package App\Models
 */
class Alert extends Model
{
    /**
     * @var string
     */
    protected $table = 'alert';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Returns the creation date with format
     *
     * @return string
     */
    public function getDateWithFormat($format = 'd/m/Y') {
        $date = new \DateTime($this->created_at);

        return $date->format($format);
    }


    /**
     * Returns the type of the alert
     *
     * @return AlertType
     */
    public function getType() {
        return new AlertType($this->type);
    }


    /**
     * Returns the contract associated to the alert
     *
     * @return Contract
     */
    public function getContract() {
        return $this->hasOne('App\Models\Contract', 'id', 'contract_id')->getResults();
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getType()->getName() . " del contrato " . $this->getContract();
    }
}
