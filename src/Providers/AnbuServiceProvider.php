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
        /**
         * We need this enabled to gather queries.
         */
        $this->app->db->enableQueryLog();

        /**
         * Create the agent on framework bootstrap.
         */
        $agent = new Agent($this->app);

        /**
         * Store in the container.
         */
        $this->app->instance(Agent::class, $agent);

        /**
         * Fire module register hooks.
         */
        $agent->registerHook();
    }
}
