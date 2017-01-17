<?php

namespace App\Http\Controllers;

use App\Repositories\MunicipalityRepository;

/**
 * Class MunicipalitiesController
 * @package App\Http\Controllers
 */
class MunicipalitiesController extends Controller
{

    /**
     * @var MunicipalityRepository
     */
    private $municipalityRepository;


    /**
     * MunicipalitiesController constructor.
     * @param MunicipalityRepository $municipalityRepository
     */
    public function __construct(MunicipalityRepository $municipalityRepository) {
        $this->municipalityRepository = $municipalityRepository;
    }


    /**
     * Returns the municiplity by provice id
     * @param $provinceId
     */
    public function getByProvince($provinceId) {
        return $this->municipalityRepository->findBy('province_id', $provinceId);
    }
}