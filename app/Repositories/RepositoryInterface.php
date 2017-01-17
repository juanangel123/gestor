<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 * @link https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/#Directory_structure
 */
interface RepositoryInterface {

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));


    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'));


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'));
}