<?php

namespace App\Repositories;

/**
 * Class DocumentRepository
 * @package App\Repositories
 */
class DocumentRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Document';
    }
}