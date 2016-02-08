<?php

namespace Anbu\Profiler\Providers;

use Anbu\Profiler\Agent;
use Illuminate\Support\ServiceProvider;

/**
 * Class AnbuServiceProvider
 *
 * @package \Anbu\Profiler\Providers
 */
class AnbuServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $agent = new Agent($this->app);
        $this->app->instance(Agent::class, $agent);
        $agent->registerHook();
    }
}
