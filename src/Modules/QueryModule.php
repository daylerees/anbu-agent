<?php

namespace Anbu\Profiler\Modules;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class QueryModule
 *
 * @package \Anbu\Profiler\Modules
 */
class QueryModule extends AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'query';

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
     *
     * @return void
     */
    public function after(Application $app)
    {
        foreach ($app->db->getConnections() as $name => $connection) {
            $this->data['queries'][$name] = $connection->getQueryLog();
        }
    }
}
