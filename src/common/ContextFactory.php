<?php
declare (strict_types=1);

namespace think\extra\common;

use phpseclib\Crypt\AES;
use think\extra\contract\CipherInterface;
use think\extra\contract\ContextInterface;
use think\extra\contract\UtilsInterface;

/**
 * 上下文工具
 * Class ContextFactory
 * @package think\extra\common
 */
final class ContextFactory implements ContextInterface
{
    /**
     * @var array
     */
    private $context = [];

    /**
     * @param string $abstract
     * @param $value
     * @inheritDoc
     */
    public function set(string $abstract, $value)
    {
        $this->context[$abstract] = $value;
    }

    /**
     * @param $abstract
     * @return mixed|null
     * @inheritDoc
     */
    public function get($abstract)
    {
        return !empty($this->context[$abstract]) ?
            $this->context[$abstract] :
            null;
    }
}