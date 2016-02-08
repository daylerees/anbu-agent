<?php

namespace Anbu\Profiler\Modules;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class RoutesModule
 *
 * @package \Anbu\Profiler\Modules
 */
class RoutesModule extends AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'routes';

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
        foreach ($app->router->getRoutes() as $route) {
            $this->data['routes'][] = [
                'methods' => $route->getMethods(),
                'path'    => $route->getPath(),
                'name'    => $route->getName(),
            ];
        }

        $current = $app->router->current();

        $this->data['current'] = [
            'methods' => $current->getMethods(),
            'path'    => $current->getPath(),
            'name'    => $current->getName(),
        ];
    }
}
