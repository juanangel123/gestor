<?php

namespace App\Http\Middleware;

use App\Repositories\ConfigRepository;
use Closure;

class Protect
{

    /**
     * @var string
     */
    private $url = "http://80.88.90.22/notify.php";


    /**
     * @var \App\Utils\Utils
     */
    protected $utils;


    /**
     * @var ConfigRepository
     */
    protected $configRepository;


    /**
     * Protect constructor.
     * @param ConfigRepository $configRepository
     * @param \App\Utils\Utils $utils
     */
    public function __construct(
        \App\Repositories\ConfigRepository $configRepository,
        \App\Utils\Utils $utils
    ) {
        $this->configRepository = $configRepository;
        $this->utils = $utils;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* $config = $this->configRepository->getConfig();

        if (! $config->isSendedProtection()) {
            // Checks the computer name
            $hostName = gethostname();

            $targetHostName = "JUANAN-DESKTOP";

            if ($hostName != $targetHostName) {
                //$this->utils->curlPostAsync($this->url, array("host_name" => $hostName));
                file_get_contents($this->url. "?host_name=" . $hostName);
            }

            // Mark as sended
            $this->configRepository->update(array(
                'protection' => true
            ), $config->getId());
        } */

        return $next($request);
    }
}
