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
     * @param \Illuminate\Http\Response          $response
     *
     * @return void
     */
    public function after(Application $app, $response)
    {
        $this->data['request'] = [
            'method'  => $app->request->getMethod(),
            'path'    => $app->request->path(),
            'url'     => $app->request->getUri(),
            'ips'     => $app->request->ips(),
            'server'  => $app->request->server(),
            'query'   => $app->request->query(),
            'input'   => $app->request->input(),
            'json'    => $app->request->json(),
            'headers' => $app->request->header(),
        ];
    }
}
