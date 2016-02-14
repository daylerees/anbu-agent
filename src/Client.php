<?php

namespace Anbu\Profiler;

use Exception;
use Illuminate\Config\Repository;

/**
 * Class Client
 *
 * @package \Anbu\Profiler
 */
class Client
{
    /**
     * Service URL to report to.
     */
    const SERVICE_URL = 'https://anbu.io/reports/submit';

    /**
     * Anbu.io token.
     *
     * @var string
     */
    protected $token;

    /**
     * Client constructor.
     *
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->token = $config->get('anbu.token');
    }

    /**
     * Send a report.
     *
     * @param string $key
     * @param array  $report
     */
    public function send($key, $report)
    {
        $curl = $this->getCurlInstance($key, $report);

        try {
            curl_exec($curl);
            curl_close($curl);
        } catch (Exception $exception) {
            // Maybe post a log?
        }
    }

    /**
     * Prepare a new CURL instance.
     *
     * @param string $key
     * @param array  $report
     *
     * @return resource
     */
    protected function getCurlInstance($key, $report)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, self::SERVICE_URL);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($report));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders($key));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        return $curl;
    }

    /**
     * Get request headers.
     *
     * @param string $key
     *
     * @return array
     */
    protected function getHeaders($key)
    {
        return [
            "X-Anbu-Token: {$this->token}",
            "X-Anbu-Key: {$key}",
        ];
    }
}
