<?php
declare (strict_types=1);

namespace think\extra\service;

use think\extra\common\ContextFactory;
use think\extra\contract\ContextInterface;
use think\Service;

class ContextService extends Service
{
    public $bind = [
        ContextInterface::class => ContextFactory::class
    ];
}