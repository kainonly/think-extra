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
class ContextFactory implements ContextInterface
{
    /**
     * @var array 上下文内容
     */
    private $context = [];

    /**
     * @param string $abstract
     * @param mixed $value
     * @inheritDoc
     */
    public function set(string $abstract, $value): void
    {
        $this->context[$abstract] = $value;
    }

    /**
     * @param string $abstract
     * @return mixed|null
     * @inheritDoc
     */
    public function get(string $abstract)
    {
        return !empty($this->context[$abstract]) ?
            $this->context[$abstract] :
            null;
    }
}