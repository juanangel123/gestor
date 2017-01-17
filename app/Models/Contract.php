<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contract
 * @package App\Models
 */
class Contract extends Model
{

    /**
     * Path where the contract documents are stored
     */
    const BASE_PATH = "contracts";


    /**
     * @var string
     */
    protected $table = 'contract';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Returns the date
     *
     * @return \DateTime
     */
    public function getDate() {
        return new \DateTime($this->date);
    }


    /**
     * Returns the CUPS
     *
     * @return string
     */
    public function getCUPS() {
        return $this->cups;
    }


    /**
     * Returns the mean consuption
     *
     * @return \DateTime
     */
    public function getMeanConsuption() {
        return $this->mean_consuption;
    }


    /**
     * Returns the date
     *
     * @return string
     */
    public function getDateWithFormat($format = 'd/m/Y') {
        $date = new \DateTime($this->date);

        return $date->format($format);
    }


    /**
     * Returns the tariff
     *
     * @return Tariff
     */
    public function getTariff() {
        return new Tariff($this->type);
    }


    /**
     * Returns if the comission is paid
     *
     * @return bool
     */
    public function isComissionPaid() {
        return $this->comission_paid ? true : false;
    }


    /**
     * Returns the client
     *
     * @return mixed
     */
    public function getClient() {
        return $this->hasOne('App\Models\Client', 'id', 'client_id')->getResults();
    }


    /**
     * Returns the supplier company
     *
     * @return mixed
     */
    public function getSupplierCompany() {
        return $this->hasOne('App\Models\SupplierCompany', 'id', 'supplier_company_id')->getResults();
    }


    /**
     * Returns the supply address
     *
     * @return mixed
     */
    public function getSupplyAddress() {
        return $this->hasOne('App\Models\Address', 'id', 'supply_address_id')->getResults();
    }


    /**
     * Returns the document path
     *
     * @return string
     */
    public function getDocumentPath() {
        return self::BASE_PATH . DIRECTORY_SEPARATOR . $this->getId() . DIRECTORY_SEPARATOR;
    }


    /**
     * Returns the documents
     *
     * @return mixed
     */
    public function getDocuments() {
        return $this->hasMany('App\Models\Document', 'contract_id', 'id')->getResults();
    }


    /**
     * @return string
     */
    public function __toString() {
        return $this->getDateWithFormat() . " | " . $this->getClient()->getName() . " " . $this->getCUPS() . " " . $this->getTariff()->getName();
    }
}
