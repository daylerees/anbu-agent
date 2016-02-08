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

        $this->data['request'] = [
            'method'  => $request->getMethod(),
            'path' => $request->path(),
            'url'     => $request->getUri(),
            'ips'     => $request->ips(),
            'server'  => $request->server(),
            'query'  => $request->query(),
            'input'  => $request->input(),
            'json'  => $request->json(),
            'headers' => $request->header(),
        ];
    }
}
