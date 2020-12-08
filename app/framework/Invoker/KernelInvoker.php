<?php

namespace Framework\Invoker;

use Framework\Commands\IFrameworkCommand;

class KernelInvoker
{
    public function handle(IFrameworkCommand $command)
    {
        return $command->execute();
    }
}
