<?php

namespace App\Repositories;

/**
 * Class ProvinceRepository
 * @package App\Repositories
 */
class ProvinceRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Province';
    }
}