<?php

namespace App\Models;

use App\Helpers\Enum;

class AlertType extends Enum
{
    const ALERT_6_MONTHS = 1;
    const ALERT_10_MONTHS = 2;
    const ALERT_11_MONTHS = 3;


    /**
     * Returns the name
     *
     * @return string
     */
    public function getName() {
        switch ($this->value()) {
            default:
            case self::ALERT_6_MONTHS:
                return "Alerta 6 meses";
                break;
            case self::ALERT_10_MONTHS:
                return "Alerta 10 meses";
                break;
            case self::ALERT_11_MONTHS:
                return "Alerta 11 meses";
                break;
        }

    }
}