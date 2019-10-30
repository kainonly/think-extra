<?php

declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\JwtFactory;
use think\Service;

final class JwtService extends Service
{
    public function register()
    {
        $this->app->bind('jwt', function () {
            $secret = $this->app->config
                ->get('app.app_secret');
            $config = $this->app->config
                ->get('jwt');

            return new JwtFactory($secret, $config);
        });
    }
}