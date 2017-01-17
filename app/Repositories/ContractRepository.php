<?php

namespace App\Repositories;

/**
 * Class ContractRepository
 * @package App\Repositories
 */
class ContractRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Contract';
    }
}