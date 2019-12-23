<?php
declare (strict_types=1);

namespace think\extra\contract;

use Exception;
use Stringy\Stringy;
use Ramsey\Uuid\UuidInterface;


interface UtilsInterface
{
    /**
     * 生成 Stringy 工具
     * @param string $str
     * @param string $encoding
     * @return Stringy
     */
    public function stringy(string $str, string $encoding = ''): Stringy;

    /**
     * 生成 UUID V4
     * @return UuidInterface
     * @throws Exception
     */
    public function uuid(): UuidInterface;
}