<?php

declare(strict_types = 1);

use Framework\Commands\ProcessCommand;
use Framework\Commands\RegisterConfigCommand;
use Framework\Commands\RegisterRoutesCommand;
use Framework\Invoker\KernelInvoker;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var RouteCollection
     */
    public $routeCollection;

    /**
     * @var ContainerBuilder
     */
    public $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $invoker = new KernelInvoker();
        $invoker->handle(new RegisterRoutesCommand($this));
        $invoker->handle(new RegisterConfigCommand($this));

        return $invoker->handle(new ProcessCommand($this, $request));
    }
}
