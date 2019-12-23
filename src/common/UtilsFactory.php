<?php
declare (strict_types=1);

namespace think\extra\common;

use Exception;
use Stringy\Stringy;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use think\extra\contract\UtilsInterface;

/**
 * 工具生产类
 * Class UtilsFactory
 * @package think\extra\common
 */
class UtilsFactory implements UtilsInterface
{
    /**
     * @param string $str
     * @param string $encoding
     * @return Stringy
     * @inheritDoc
     */
    public function stringy(string $str, string $encoding = ''): Stringy
    {
        return Stringy::create($str, $encoding);
    }

    /**
     * @return UuidInterface
     * @throws Exception
     * @inheritDoc
     */
    public function uuid(): UuidInterface
    {
        return Uuid::uuid4();
    }
}