<?php

declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\HashFactory;
use think\Service;

final class HashService extends Service
{
    public function register()
    {
        $this->app->bind('hashing', function () {
            $type = $this->app->config
                ->get('hashing');

            return new HashFactory($type);
        });
    }
}