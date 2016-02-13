<?php

namespace Anbu\Profiler;

use Illuminate\Foundation\Application;

/**
 * Class Agent
 *
 * @package \Anbu\Profiler
 */
class Agent
{
    /**
     * Reporting URL for button.
     */
    const REPORT_URL = 'https://anbu.io/reports/%s';

    /**
     * Anbu request key.
     *
     * @var string
     */
    protected $key;

    /**
     * Application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The anbu service client.
     *
     * @var \Anbu\Profiler\Client
     */
    protected $client;

    /**
     * Registered modules.
     *
     * @var array
     */
    protected $modules = [];

    /**
     * Is the profiler enabled?
     *
     * @var boolean
     */
    protected $enabled = false;

    /**
     * Default modules to load.
     *
     * @var array
     */
    protected $defaultModules = [
        Modules\GeneralModule::class,
        Modules\RequestModule::class,
        Modules\RoutesModule::class,
        Modules\QueryModule::class,
        Modules\LogModule::class,
    ];

    /**
     * Load modules.
     *
     * @param \Illuminate\Foundation\Application $app
     * @param \Anbu\Profiler\Client              $client
     */
    public function __construct(Application $app, Client $client)
    {
        $this->app = $app;
        $this->client = $client;

        $this->key = uniqid(null, true);

        foreach ($this->defaultModules as $module) {
            $this->modules[] = $app->make($module);
        }

        $this->enabled = $app->config->get('anbu.enabled');
    }

    /**
     * Fire the module registration hooks.
     *
     * @return void
     */
    public function registerHook()
    {
        foreach ($this->modules as $module) {
            $module->register($this->app);
        }
    }

    /**
     * Fire the module before hooks.
     *
     * @return void
     */
    public function beforeHook()
    {
        foreach ($this->modules as $module) {
            $module->before($this->app);
        }
    }

    /**
     * Fire the module after hooks.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return void
     */
    public function afterHook($response)
    {
        foreach ($this->modules as $module) {
            $module->after($this->app, $response);
        }

        $this->report();
        $this->attachLink($response);
    }

    /**
     * Fetch the anbu request key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Render the profile report.
     *
     * @return void
     */
    public function report()
    {
        $report = [];

        foreach ($this->modules as $module) {
            $report['modules'][$module->getName()] = $module->flatten();
        }

        $this->client->send($this->key, $report);
    }

    /**
     * Attach a report link to the view.
     *
     * @param \Illuminate\Http\Response $response
     */
    protected function attachLink($response)
    {
        /**
         * We only attach the button to HTML responses.
         */
        $contentType = $response->headers->get('Content-Type');
        if (str_contains($contentType, 'text/html')) {
            $response->setContent($response->getContent().$this->fetchButtonHtml());
        }
    }

    /**
     * Generate the Anbu button HTML.
     *
     * @return string
     */
    protected function fetchButtonHtml()
    {
        $url = sprintf(self::REPORT_URL, $this->key);
        return $this->app->view->make('anbu::button', compact('url'))->render();
    }

    /**
     * Check if the profiler is enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
