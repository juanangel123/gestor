<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Class PowerContractedRepository
 * @package App\Repositories
 */
class PowerContractedRepository extends Repository {

    /**
     * @var ContractRepository
     */
    protected $contractRepository;

    /**
     * PowerContractedRepository constructor.
     * @param App $app
     * @param Collection $collection
     * @param ContractRepository $contractRepository
     */
    public function __construct(
        App $app,
        Collection $collection,
        ContractRepository $contractRepository
    ) {
        $this->contractRepository = $contractRepository;
        parent::__construct($app, $collection);
    }


    /**
     * Specify model class name
     *
     * @return mixed
     */
    function model() {
        return 'App\Models\PowerContracted';
    }


    /**
     * Updates the pwc by contract
     *
     * @param integer $contractId
     * @param array $pwcs
     */
    public function updateByContract($contractId, $newPwcs) {
        // 1. Get the pwcs by contract
        $pwcs = $this->findBy('contract_id', $contractId);

        // 2. Remove the older pwcs
        foreach ($pwcs as $pwc) {
            $this->delete($pwc->getId());
        }

        // 3. Save the new pwcs
        foreach ($newPwcs as $newPwc) {
            if ($newPwc) {
                $this->create(array(
                    'contract_id' => $contractId,
                    'total' => $newPwc,
                    'created_at' => new \DateTime()
                ));
            }
        }
    }
}