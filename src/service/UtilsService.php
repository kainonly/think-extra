<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\UtilsFactory;
use think\extra\contract\UtilsInterface;
use think\Service;

class UtilsService extends Service
{
    public function register()
    {
        $this->app->bind(UtilsInterface::class, function () {
            $options = $this->app->config
                ->get('app');
            return new UtilsFactory($this->app, $options);
        });
    }
}