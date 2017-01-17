<?php

namespace App\Repositories;

/**
 * Class ConfigRepository
 * @package App\Repositories
 */
class ConfigRepository extends Repository {

    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\Config';
    }

    /**
     * Returns the config (unique)
     *
     * @return mixed
     */
    public function getConfig() {
        $config = $this->all()->first();

        if (! $config) {
            $newConfigId = $this->create(array(
                'created_at' => new \DateTime()
            ));

            $config = $this->find($newConfigId);
        }

        return $config;
    }
}