<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Config
 * @package App\Models
 */
class Config extends Model
{
    /**
     * @var string
     */
    protected $table = 'config';


    /**
     * Returns the id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Returns if sended protection
     *
     * @return mixed
     */
    public function isSendedProtection() {
        return $this->protection;
    }


    /**
     * Returns the last time alert
     *
     * @return \DateTime
     */
    public function getLastTimeAlert() {
        return new \DateTime($this->last_time_alert);
    }
}
