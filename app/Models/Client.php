<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * @package App\Models
 */
class Client extends Model
{
    /**
     * Path where the client documents are stored
     */
    const BASE_PATH = "clients";


    /**
     * @var string
     */
    protected $table = 'client';


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
     * Returns the telephone
     *
     * @return mixed
     */
    public function getTelephone() {
        return $this->telephone;
    }


    /**
     * Returns the mobile
     *
     * @return mixed
     */
    public function getMobile() {
        return $this->mobile;
    }


    /**
     * Returns the email
     *
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }


    /**
     * Returns the vat id
     *
     * @return mixed
     */
    public function getVatId() {
        return $this->vat_id;
    }


    /**
     * Returns the client type
     *
     * @return ClientType
     */
    public function getClientType() {
       return new ClientType($this->client_type);
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
        return $this->hasMany('App\Models\Document', 'client_id', 'id')->getResults();
    }


    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }
}
