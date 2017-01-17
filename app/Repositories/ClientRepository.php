<?php

namespace App\Repositories;

/**
 * Class ClientRepository
 * @package App\Repositories
 */
class ClientRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Client';
    }
}