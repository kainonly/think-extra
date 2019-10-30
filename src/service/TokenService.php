<?php

declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\TokenFactory;
use think\Service;

final class TokenService extends Service
{
    public function register()
    {
        $this->app->bind('token', function () {
            $config = $this->app->config;
            return new TokenFactory(
                $config->get('app.app_secret'),
                $config->get('token')
            );
        });
    }
}