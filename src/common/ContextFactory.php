<?php
declare (strict_types=1);

namespace think\extra\common;

use think\extra\contract\ContextInterface;

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
    private array $context = [];

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
        return $this->context[$abstract] ?? null;
    }
}