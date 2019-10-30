<?php

declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\CipherFactory;
use think\extra\contract\CipherInterface;
use think\extra\contract\UtilsInterface;
use think\Service;

final class CipherService extends Service
{
    public function register()
    {
        $this->app->bind(CipherInterface::class, function () {
            $config = $this->app->config
                ->get('app');
            $args = new \stdClass();
            $args->key = $config['app_secret'];
            $args->iv = $config['app_id'];
            return new CipherFactory(
                $args,
                $this->app->make(UtilsInterface::class)
            );
        });
    }
}