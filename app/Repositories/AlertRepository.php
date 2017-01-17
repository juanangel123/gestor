<?php

namespace App\Repositories;

/**
 * Class AlertRepository
 * @package App\Repositories
 */
class AlertRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Alert';
    }
}