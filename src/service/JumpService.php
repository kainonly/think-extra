<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\JumpFactory;
use think\extra\contract\JumpInterface;
use think\Service;

class JumpService extends Service
{
    public function register()
    {
        $this->app->bind(JumpInterface::class, function () {
            $options = $this->app->config
                ->get('app');
            return new JumpFactory($this->app->request, $options);
        });
    }
}