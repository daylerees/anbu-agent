<?php

namespace Anbu\Profiler\Modules;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class ConfigModule
 *
 * @package \Anbu\Profiler\Modules
 */
class ConfigModule extends AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'config';

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
        $this->data['config'] = $app->config->all();
    }
}
