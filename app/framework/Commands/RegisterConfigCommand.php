<?php


namespace Framework\Commands;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Kernel;

class RegisterConfigCommand implements IFrameworkCommand
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

        try {
            $fileLocator = new FileLocator($rootDir . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader($kernel->containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (\Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }
}
