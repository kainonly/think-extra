<?php
declare (strict_types=1);

namespace think\extra\contract;

interface ContextInterface
{
    /**
     * 设置内容
     * @param string $abstract
     * @param mixed $value
     */
    public function set(string $abstract, $value): void;

    /**
     * 获取内容
     * @param string $abstract
     * @return mixed|null
     */
    public function get(string $abstract);
}