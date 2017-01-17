<?php

namespace App\Repositories\Criteria;

use App\Repositories\RepositoryInterface as Repository;
use App\Repositories\RepositoryInterface;

/**
 * Class Criteria
 * @package App\Repositories\Criteria
 */
abstract class Criteria {

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository);
}