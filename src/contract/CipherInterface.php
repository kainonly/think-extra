<?php

namespace think\extra\contract;

interface CipherInterface
{
    /**
     * 加密
     * @param string|array $context 加密内容
     * @return string 密文
     */
    public function encrypt($context);

    /**
     * 解密
     * @param string $ciphertext 密文
     * @param bool $is_array 是否为数组
     * @return string|array 数据源
     */
    public function decrypt(string $ciphertext, bool $auto_conver = true);
}