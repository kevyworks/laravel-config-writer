<?php

namespace Kevyworks\Laravel\ConfigWriter;

use Laravel\Lumen\Application;

class LumenServiceProvider extends ServiceProvider
{
    /** @var Application */
    protected $app;

    protected function getConfigPath(): string
    {
        return $this->app->getConfigurationPath();
    }
}
