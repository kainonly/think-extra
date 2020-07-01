<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\TokenFactory;
use think\extra\contract\TokenInterface;
use think\Service;

class TokenService extends Service
{
    public function register(): void
    {
        $this->app->bind(TokenInterface::class, function () {
            $config = $this->app->config;
            return new TokenFactory(
                $config->get('app.app_secret'),
                $config->get('token')
            );
        });
    }
}