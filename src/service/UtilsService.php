<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\UtilsFactory;
use think\extra\contract\UtilsInterface;
use think\Service;

class UtilsService extends Service
{
    public $bind = [
        UtilsInterface::class => UtilsFactory::class,
    ];
}