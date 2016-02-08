<?php

namespace Anbu\Profiler\Modules;

use Illuminate\Foundation\Application;
use Anbu\Profiler\Abstracts\AbstractModule;
use Anbu\Profiler\Contracts\ModuleContract;

/**
 * Class RequestModule
 *
 * @package \Anbu\Profiler\Modules
 */
class RequestModule extends AbstractModule implements ModuleContract
{
    /**
     * Module name.
     *
     * @var string
     */
    protected $name = 'request';

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
        $request = $app->request;

        $headers = [];

        foreach ($request->headers->all() as $key => $header) {
            $headers[$key] = array_shift($header);
        }

        $this->data['request'] = [
            'method'  => $request->getMethod(),
            'url'     => $request->getUri(),
            'headers' => $headers,
            'ips'     => $request->ips(),
            'data'    => $request->all(),
            'server'  => $request->server(),
        ];
    }
}
