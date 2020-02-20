<?php
declare (strict_types=1);

namespace think\extra\common;

use phpseclib\Crypt\AES;
use think\extra\contract\CipherInterface;
use think\extra\contract\UtilsInterface;

/**
 * 对称加密类
 * Class HashFactory
 * @package think\extra\common
 */
class CipherFactory implements CipherInterface
{
    /**
     * @var string 密钥
     */
    private $key;

    /**
     * @var string 偏移量
     */
    private $iv;

    /**
     * 工具类
     * @var UtilsInterface
     */
    private $utils;

    /**
     * 构造处理
     * CipherFactory constructor.
     * @param string $key
     * @param string $iv
     * @param UtilsInterface $utils
     */
    public function __construct(
        string $key,
        string $iv,
        UtilsInterface $utils
    )
    {
        $this->key = $key;
        $this->iv = $iv;
        $this->utils = $utils;
    }

    /**
     * 生产加密工具
     * @return AES
     */
    private function factoryCipher(): AES
    {
        $cipher = new AES();
        $cipher->setKey($this->key);
        $cipher->setIV($this->iv);
        return $cipher;
    }

    /**
     * @param array|string $context
     * @return string
     * @inheritDoc
     */
    public function encrypt($context): string
    {
        $cipher = $this->factoryCipher();
        if (is_string($context)) {
            return base64_encode($cipher->encrypt($context));
        }
        if (is_array($context)) {
            return base64_encode($cipher->encrypt(json_encode($context)));
        }
        return '';
    }

    /**
     * @param string $ciphertext
     * @param bool $auto_conver
     * @return array|mixed|string
     * @inheritDoc
     */
    public function decrypt(string $ciphertext, bool $auto_conver = true)
    {
        $cipher = $this->factoryCipher();
        $data = $cipher->decrypt(base64_decode($ciphertext));
        return $this->utils->stringy($data)->isJson() && $auto_conver ?
            json_decode($data, true) : $data;
    }
}