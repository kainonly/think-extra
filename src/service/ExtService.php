<?php

declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\ExtFactory;
use think\Service;

final class ExtService extends Service
{
    public $bind = [
        'ext' => ExtFactory::class,
    ];
}