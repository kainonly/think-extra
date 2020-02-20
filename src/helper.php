<?php
declare(strict_types=1);

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringy\Stringy;

if (!function_exists('stringy')) {
    /**
     * 生成 Stringy 工具
     * @param string $str
     * @param string $encoding
     * @return Stringy
     */
    function stringy(string $str, string $encoding = ''): Stringy
    {
        return Stringy::create($str, $encoding);
    }
}

if (!function_exists('uuid')) {
    /**
     * 生成 UUID V4
     * @return UuidInterface
     * @throws Exception
     */
    function uuid(): UuidInterface
    {
        return Uuid::uuid4();
    }
}