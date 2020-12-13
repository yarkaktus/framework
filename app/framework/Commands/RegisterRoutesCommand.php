<?php


namespace Framework\Commands;

use Kernel;

class RegisterRoutesCommand implements IFrameworkCommand
{
    /**
     * @var Kernel
     */
    protected $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function execute(): void
    {
        $kernel =  $this->kernel;
        $rootDir = dirname(dirname(__DIR__));
        $kernel->routeCollection = require $rootDir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routing.php';
        $kernel->containerBuilder->set('route_collection', $kernel->routeCollection);
    }
}
