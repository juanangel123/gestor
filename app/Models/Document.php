<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 * @package App\Models
 */
class Document extends Model
{
    /**
     * @var string
     */
    protected $table = 'document';


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
     * @return \DateTime
     */
    public function getName() {
        return $this->name;
    }


    /**
     * Returns the path
     *
     * @return \DateTime
     */
    public function getPath() {
        return $this->path;
    }


    /**
     * Returns the mime type
     *
     * @return \DateTime
     */
    public function getMimeType() {
        return $this->mime_type;
    }


    /**
     * Returns the size
     *
     * @return \DateTime
     */
    public function getSize() {
        return $this->size;
    }


    /**
     * Returns the contract
     *
     * @return mixed
     */
    public function getContract() {
        return $this->hasOne('App\Models\Contract', 'id', 'contract_id')->getResults();
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
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }
}
