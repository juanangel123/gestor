<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

use App\Repositories\Criteria\CriteriaInterface;
use App\Repositories\Criteria\Criteria;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface, CriteriaInterface
{

    /**
     * @var App
     */
    private $app;


    /**
     * @var Model
     */
    protected $model;


    /**
     * @var Collection
     */
    protected $criteria;


    /**
     * @var bool
     */
    protected $skipCriteria = false;


    /**
     * @param App $app
     * @param Collection $collection
     * @throws RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }


    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();


    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }


    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->insertGetId($data);
    }


    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }


    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        $this->applyCriteria();
        //return $this->model->where($attribute, '=', $value)->first($columns);
        return $this->model->where($attribute, '=', $value)->get($columns);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }


    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false)
    {
        $this->applyCriteria();
        $model = $this->model;
        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model->get($columns);
    }


    /**
     * @return $this
     */
    public function resetScope() {
        $this->skipCriteria(false);
        return $this;
    }


    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true) {
        $this->skipCriteria = $status;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCriteria() {
        return $this->criteria;
    }


    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria) {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }


    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria) {
        $this->criteria->push($criteria);
        return $this;
    }


    /**
     * @return $this
     */
    public function applyCriteria() {
        if($this->skipCriteria === true)
            return $this;

        foreach($this->getCriteria() as $criteria) {
            if($criteria instanceof Criteria)
                $this->model = $criteria->apply($this->model, $this);
        }

        return $this;
    }
}