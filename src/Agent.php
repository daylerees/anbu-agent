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
         * I need to tidy the hell out of this method.
         * Maybe load the attachement from a view.
         */
        $contentType = $response->headers->get('Content-Type');
        if (str_contains($contentType, 'text/html')) {
            $url = "http://anbu.io/reports/{$this->key}";
            $link = "<a style=\"position:fixed; bottom:10px; left:10px;\" href=\"{$url}\"><img height=\"32\" width=\"32\" src=\"data:image/png;base64,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
\"/></a>";
            $response->setContent($response->getContent().$link);
        }
    }
}
