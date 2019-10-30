<?php
declare (strict_types=1);

namespace think\extra\common;

use Ramsey\Uuid\Uuid;
use Stringy\Stringy;
use think\extra\contract\UtilsInterface;

/**
 * 工具生产类
 * Class UtilsFactory
 * @package think\extra\common
 */
final class UtilsFactory implements UtilsInterface
{
    /**
     * @param string $str
     * @param string|null $encoding
     * @return Stringy
     * @inheritDoc
     */
    public function stringy($str = '', string $encoding = null)
    {
        return Stringy::create($str, $encoding);
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     * @throws \Exception
     * @inheritDoc
     */
    public function uuid()
    {
        return Uuid::uuid4();
    }
}