<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\HashFactory;
use think\extra\contract\HashInterface;
use think\Service;

class HashService extends Service
{
    public function register(): void
    {
        $this->app->bind(HashInterface::class, function () {
            $options = $this->app->config->get('hashing');
            return new HashFactory($options);
        });
    }
}