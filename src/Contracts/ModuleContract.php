<?php

namespace Anbu\Profiler\Contracts;

use Illuminate\Foundation\Application;

/**
 * Interface ModuleContract
 *
 * @package Anbu\Profiler\Contracts
 */
interface ModuleContract
{
    /**
     * Get module name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get module version.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Module register hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function register(Application $app);

    /**
     * Module before response hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function before(Application $app);

    /**
     * Module after response hook.
     *
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\Http\Response          $response
     *
     * @return void
     */
    public function after(Application $app, $response);

    /**
     * Flatten a module for dispatch to service.
     *
     * @return array
     */
    public function flatten();
}
