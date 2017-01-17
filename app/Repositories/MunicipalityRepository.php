<?php

namespace App\Repositories;

/**
 * Class MunicipalityRepository
 * @package App\Repositories
 */
class MunicipalityRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Municipality';
    }
}