<?php

namespace App\Repositories;

/**
 * Class AddressRepository
 * @package App\Repositories
 */
class AddressRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Address';
    }
}