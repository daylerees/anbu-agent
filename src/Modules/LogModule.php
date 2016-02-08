<?php

namespace Anbu\Profiler\Modules;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class LogModule
 *
 * @package \Anbu\Profiler\Modules
 */
class LogModule extends AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'log';

    /**
     * Module version.
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Module register hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        $app->events->listen('illuminate.log', [$this, 'storeLogEvent']);
    }

    /**
     * Store a log in the data array.
     *
     * @param string $level
     * @param string $message
     * @param string $context
     *
     * @return void
     */
    public function storeLogEvent($level, $message, $context)
    {
        $time = microtime(true);
        $this->data['logs'][] = compact('level', 'message', 'context', 'time');
    }
}
