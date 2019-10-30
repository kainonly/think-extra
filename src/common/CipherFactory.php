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
final class CipherFactory implements CipherInterface
{
    /**
     * 钥匙串
     * @var AES
     */
    private $cipher;
    /**
     * 工具类
     * @var UtilsInterface
     */
    private $utils;

    /**
     * 构造处理
     * CipherFactory constructor.
     * @param string $key 密钥
     * @param string $iv 偏移量
     */
    public function __construct(\stdClass $args, UtilsInterface $utils)
    {
        $this->cipher = new AES();
        $this->cipher->setKey($args->key);
        $this->cipher->setIV($args->iv);
        $this->utils = $utils;
    }

    /**
     * @param array|string $context
     * @return string
     * @inheritDoc
     */
    public function encrypt($context)
    {
        if (is_string($context)) {
            return base64_encode($this->cipher->encrypt($context));
        } elseif (is_array($context)) {
            return base64_encode($this->cipher->encrypt(json_encode($context)));
        } else {
            return '';
        }
    }

    /**
     * @param string $ciphertext
     * @param bool $auto_conver
     * @return array|mixed|string
     * @inheritDoc
     */
    public function decrypt(string $ciphertext, bool $auto_conver = true)
    {
        $data = $this->cipher->decrypt(base64_decode($ciphertext));
        return $this->utils->stringy($data)->isJson() && $auto_conver ?
            json_decode($data, true) : $data;
    }
}