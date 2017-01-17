<?php

namespace App\Http\Controllers;

use App\Repositories\AlertRepository;

/**
 * Class AlertsController
 * @package App\Http\Controllers
 */
class AlertsController extends Controller {

    /**
     * @var AlertRepository
     */
    private $alertRepository;


    /**
     * MunicipalitiesController constructor.
     * @param AlertRepository $alertRepository
     */
    public function __construct(AlertRepository $alertRepository) {
        $this->alertRepository = $alertRepository;
    }


    /**
     * Show the alert list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        // Get all the clients stored
        $alerts = $this->alertRepository->all();

        // Pass to the view
        return view(
            'alerts'
        )->with('alerts', $alerts);
    }


    /**
     * Get the alerts which have not sended yet
     *
     * @return array Array of messages
     */
    public function getNotSended() {
        $alerts = $this->alertRepository->findBy('sended', false);

        $alertMessages = array();

        foreach ($alerts as $alert) {
            array_push($alertMessages, $alert->__toString());

            // Set alert sended
            $this->alertRepository->update(array(
                'sended' => true
            ), $alert->getId());
        }

        return $alertMessages;
    }
}