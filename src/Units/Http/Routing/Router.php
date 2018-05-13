<?php

namespace Lenzy\Support\Units\Http\Routing;

use Illuminate\Routing\Router as LaravelRouter;

abstract class Router
{
    /**
     * @var LaravelRouter
     */
    protected $router;

    /**
     * @var array
     */
    protected $options;
    
    public function __construct(array $options)
    {
        $this->router = app('router');
        $this->options = $options;
    }

    /**
     * Registrar rotas.
     */
    public function register()
    {
        $this->router->group($this->options, function () {
            $this->routes();
        });
    }
    
    /**
     * Definir rotas.
     *
     * @return mixed
     */
    abstract public function routes();
}
