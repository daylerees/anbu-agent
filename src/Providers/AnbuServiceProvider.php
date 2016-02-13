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
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Publish configuration.
         */
        $this->publishes([
            __DIR__ . '/../../resources/config/config.php' => config_path('anbu.php'),
        ]);

        /**
         * Register view namespace.
         */
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'anbu');
    }

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
        $agent = $this->app->make(Agent::class);

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
