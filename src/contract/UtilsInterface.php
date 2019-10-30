<?php

declare (strict_types=1);

namespace think\extra\contract;

use Ramsey\Uuid\UuidInterface;
use Stringy\Stringy;

interface UtilsInterface
{
    /**
     * 生成 Stringy 工具
     * @param mixed $str
     * @param string $encoding
     * @return Stringy
     */
    public function stringy($str = '', string $encoding = null);

    /**
     * 生成 UUID V4
     * @return UuidInterface
     * @throws \Exception
     */
    public function uuid();
}