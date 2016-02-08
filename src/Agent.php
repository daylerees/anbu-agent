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
     * Anbu request ID.
     *
     * @var string
     */
    protected $id;

    /**
     * Application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

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
        Modules\RequestModule::class,
        Modules\RoutesModule::class,
        Modules\QueryModule::class,
        Modules\LogModule::class,
    ];

    /**
     * Load modules.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->id = uniqid(null, true);

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
     * @return void
     */
    public function afterHook()
    {
        foreach ($this->modules as $module) {
            $module->after($this->app);
        }

        $this->report();
    }

    /**
     * Render the profile report.
     *
     * @return void
     */
    public function report()
    {
        $report = [
            'id'      => $this->id,
            'php'     => phpversion(),
            'laravel' => Application::VERSION,
            'start'   => LARAVEL_START,
            'time'    => microtime(true) - LARAVEL_START,
            'memory'  => memory_get_peak_usage(),
            'modules' => [],
        ];

        foreach ($this->modules as $module) {
            $report['modules'][$module->getName()] = $module->flatten();
        }

        response()->json($report)->send();exit;
    }
}
