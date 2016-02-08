<?php

namespace Anbu\Profiler\Middleware;

use Closure;
use Anbu\Profiler\Agent;
use Illuminate\Http\Response;

/**
 * Class AnbuMiddleware
 *
 * @package \Anbu\Profiler\Middleware
 */
class AnbuMiddleware
{
    /**
     * Agent instance.
     *
     * @var \Anbu\Profiler\Agent
     */
    protected $agent;

    /**
     * Inject dependencies.
     *
     * @param \Anbu\Profiler\Agent $agent
     */
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Fire module before hooks.
         */
        $this->agent->beforeHook();

        /**
         * Allow request to be handled.
         */
        $response = $next($request);

        /**
         * Fire module after hooks.
         */
        $this->agent->afterHook();

        return $response;
    }
}
