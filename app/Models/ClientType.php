<?php

namespace App\Models;

use App\Helpers\Enum;

/**
 * Class ClientType
 * @package App\Models
 */
class ClientType extends Enum
{
    const CLIENT_COMPANY = 1;
    const CLIENT_PHYSICAL_PERSON = 2;


    /**
     * Returns the name
     *
     * @return string
     */
    public function getName() {
        switch ($this->value()) {
            default:
            case self::CLIENT_COMPANY:
                return "Empresa";
                break;
            case self::CLIENT_PHYSICAL_PERSON:
                return "Persona física";
                break;
        }
    }
}