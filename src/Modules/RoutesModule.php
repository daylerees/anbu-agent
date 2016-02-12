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
     * @param \Illuminate\Http\Response          $response
     *
     * @return void
     */
    public function after(Application $app, $response)
    {
        foreach ($app->router->getRoutes() as $route) {

            $newRoute['methods'] = $route->getMethods();
            $newRoute['path']    = $route->getPath();
            $newRoute['name']    = $route->getName();

            $action = $route->getAction();

            if ($controller = array_get($action, 'controller')) {
                $newRoute['action'] = $controller;
            } else {
                $newRoute['action'] = 'Closure';
            }

            $this->data['routes'][] = $newRoute;
        }

        $current = $app->router->current();

        $this->data['current'] = [
            'methods' => $current->getMethods(),
            'path'    => $current->getPath(),
            'name'    => $current->getName(),
            'action'  => $current->getAction()
        ];
    }
}
