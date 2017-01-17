<?php

namespace App\Models;

use App\Helpers\Enum;

/**
 * Class Tariff
 * @package App\Models
 */
class Tariff extends Enum
{
    const TARIFF_2_0_A = 1;
    const TARIFF_2_0_DHA = 2;
    const TARIFF_2_0_DHS = 3;
    const TARIFF_2_1_A = 4;
    const TARIFF_2_1_DHA = 5;
    const TARIFF_2_1_DHS = 6;
    const TARIFF_3_0_A = 7;
    const TARIFF_3_1_A = 8;
    const TARIFF_6_1_A = 9;


    /**
     * Returns the name
     *
     * @return string
     */
    public function getName() {
        switch ($this->value()) {
            default:
            case self::TARIFF_2_0_A:
                return "Tarifa 2.0A";
                break;
            case self::TARIFF_2_0_DHA:
                return "Tarifa 2.0DHA";
                break;
            case self::TARIFF_2_0_DHS:
                return "Tarifa 2.0DHS";
                break;
            case self::TARIFF_2_1_A:
                return"Tarifa 2.1A";
                break;
            case self::TARIFF_2_1_DHA:
                return "Tarifa 2.1DHA";
                break;
            case self::TARIFF_2_1_DHS:
                return "Tarifa 2.1DHS";
                break;
            case self::TARIFF_3_0_A:
                return "Tarifa 3.0A";
                break;
            case self::TARIFF_3_1_A:
                return "Tarifa 3.1A";
                break;
            case self::TARIFF_6_1_A:
                return "Tarifa 6.1A";
                break;
        }
    }
}