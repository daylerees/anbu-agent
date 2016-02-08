<?php

namespace Anbu\Profiler\Abstracts;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class AbstractModule
 *
 * @package \Anbu\Profiler\Abstracts
 */
abstract class AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name;

    /**
     * Module version.
     *
     * @var string
     */
    protected $version;

    /**
     * Module data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Get module name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get module version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->getVersion();
    }

    /**
     * Module register hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {

    }

    /**
     * Module before response hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function before(Application $app)
    {

    }

    /**
     * Module after response hook.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function after(Application $app)
    {

    }

    /**
     * Flatten a module for dispatch to service.
     *
     * @return array
     */
    public function flatten()
    {
        return [
            'name'    => $this->name,
            'version' => $this->version,
            'data'    => $this->data
        ];
    }
}
