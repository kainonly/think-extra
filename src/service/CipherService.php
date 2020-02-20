<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\CipherFactory;
use think\extra\contract\CipherInterface;
use think\Service;

class CipherService extends Service
{
    public function register()
    {
        $this->app->bind(CipherInterface::class, function () {
            $config = $this->app->config
                ->get('app');

            return new CipherFactory(
                $config['app_secret'],
                $config['app_id']
            );
        });
    }
}