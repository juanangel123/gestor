<?php

namespace App\Http\Middleware;

use App\Repositories\AlertRepository;
use App\Repositories\ContractRepository;
use App\Repositories\Criteria\Criteria;
use Closure;

use App\Models\AlertType;
use App\Repositories\ConfigRepository;

/**
 * Class CreateAlerts
 * @package App\Http\Middleware
 */
class CreateAlerts
{

    /**
     * Time to check alerts (in hours)
     */
    const CHECK_ALERTS_INTERVAL = 24;


    /**
     * @var ConfigRepository
     */
    protected $configRepository;


    /**
     * @var ContractRepository
     */
    protected $contractRepository;


    /**
     * @var AlertRepository
     */
    protected $alertRepository;


    /**
     * Protect constructor.
     * @param ConfigRepository $configRepository
     * @param \App\Utils\Utils $utils
     */
    public function __construct(
        \App\Repositories\ConfigRepository $configRepository,
        \App\Repositories\ContractRepository $contractRepository,
        \App\Repositories\AlertRepository $alertRepository,
        \App\Utils\Utils $utils
    ) {
        $this->configRepository = $configRepository;
        $this->contractRepository = $contractRepository;
        $this->alertRepository = $alertRepository;
        $this->utils = $utils;
    }


    /**
     * Handle an incoming request.
     * Checks if we have to check for alerts and creates if we need to
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = $this->configRepository->getConfig();

        $lastTimeAlert = $config->getLastTimeAlert();
        $actualDate = new \DateTime();

        $interval = $actualDate->diff($lastTimeAlert);

        // Has passed at less one day
        if ($interval->format('%h') >= self::CHECK_ALERTS_INTERVAL) {
            $this->createAlerts();

            // Update last time
            $this->configRepository->update(array(
                'last_time_alert' => new \DateTime()
            ), $config->getId());
        }

        return $next($request);
    }


    /**
     * Sends alerts not sended yet
     */
    protected function createAlerts() {
        /* For all the contracts in the system:
         - Checks the diff date from today, = 6 months, = 10 months, = 11 months
         - If some of this, check if alert sended
         - If not, send alert
        */

        $allContracts = $this->contractRepository->all();

        foreach ($allContracts as $contract) {

            $contractDate = $contract->getDate();
            $actualDate = new \DateTime();

            $interval = $actualDate->diff($contractDate);

            // The diffs are at minimum that time (could be greater!)
            if ($interval->format("%y") == 0 && $interval->format('%m') >= 6 && $interval->format('%m') < 10 && $interval->format('%d') >= 0) {
                $typeToSend = AlertType::ALERT_6_MONTHS;
            } elseif ($interval->format("%y") == 0 && $interval->format('%m') >= 10 && $interval->format('%m') < 11 && $interval->format('%d') >= 0) {
                $typeToSend = AlertType::ALERT_10_MONTHS;
            } elseif ($interval->format("%y") > 0 || ($interval->format('%m') >= 11 && $interval->format('%d') >= 0)) {
                $typeToSend = AlertType::ALERT_11_MONTHS;
            } else {
                $typeToSend = null;
            }

            if ($typeToSend) {
                // Check if alert is sended already -> check that contract does not have an alert for that type
                $alerts = $this->alertRepository->findWhere(array(
                    'contract_id' => $contract->getId(),
                    'type' => $typeToSend
                ));

                if (! count($alerts)) {
                    // Create alert
                    $this->alertRepository->create(array(
                        'contract_id' => $contract->getId(),
                        'type' => $typeToSend,
                        'sended' => false,
                        'created_at' => new \DateTime()
                    ));
                }
            }
        }
    }
}
