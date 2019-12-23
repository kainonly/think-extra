<?php
declare (strict_types=1);

namespace think\extra\contract;

interface HashInterface
{
    /**
     * HASH加密
     * @param string $password 密码值
     * @param array $options
     * @return false|string
     */
    public function create(string $password, array $options = []);

    /**
     * HASH验证
     * @param string $password 密码值
     * @param string $hashPassword Hash值
     * @return boolean
     */
    public function check(string $password, string $hashPassword): bool;
}