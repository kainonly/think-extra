<?php

namespace think\extra\contract;

interface ContextInterface
{
    /**
     * 设置内容
     * @param string $abstract
     * @param mixed $value
     */
    public function set(string $abstract, $value);

    /**
     * 获取内容
     * @param $abstract
     * @return mixed
     */
    public function get($abstract);
}