<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\CipherFactory;
use think\extra\contract\CipherInterface;
use think\Service;

class CipherService extends Service
{
    public function register(): void
    {
        $this->app->bind(CipherInterface::class, function () {
            $app = $this->app->config->get('app');
            $cipher = $this->app->config->get('cipher');
            return new CipherFactory(
                $app['app_secret'],
                $app['app_id'],
                $cipher['compatible'] ?? true
            );
        });
    }
}