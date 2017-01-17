<?php

namespace App\Repositories;

/**
 * Class SupplierCompanyRepository
 * @package App\Repositories
 */
class SupplierCompanyRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\SupplierCompany';
    }
}