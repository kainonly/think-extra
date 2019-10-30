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
            $options = $this->app->config
                ->get('hashing');

            return new HashFactory($options);
        });
    }
}