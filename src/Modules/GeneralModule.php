<?php

namespace Anbu\Profiler\Modules;

use Anbu\Profiler\Agent;
use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;

/**
 * Class GeneralModule
 *
 * @package \Anbu\Profiler\Modules
 */
class GeneralModule extends AbstractModule
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'general';

    /**
     * Module version.
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Module after response hook.
     *
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\Http\Response          $response
     *
     * @return void
     */
    public function after(Application $app, $response)
    {
        $this->data['id']                  = $app->make(Agent::class)->getKey();
        $this->data['versions']['php']     = phpversion();
        $this->data['versions']['laravel'] = Application::VERSION;
        $this->data['environment']         = $app->config->get('app.env');
        $this->data['http']['path']        = $app->request->path();
        $this->data['http']['method']      = $app->request->method();
        $this->data['http']['status']      = $response->getStatusCode();
        $this->data['time']['start']       = LARAVEL_START;
        $this->data['time']['end']         = microtime(true);
        $this->data['time']['total']       = microtime(true) - LARAVEL_START;
        $this->data['memory']              = memory_get_peak_usage();
    }
}
