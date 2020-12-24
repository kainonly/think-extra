<?php
declare (strict_types=1);

namespace think\extra\common;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\ChaCha20;
use phpseclib3\Crypt\Common\SymmetricKey;
use think\extra\contract\CipherInterface;

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
    private string $key;

    /**
     * @var string 参考量
     */
    private string $mixed;

    /**
     * @var bool 向下兼容
     */
    private bool $compatible;

    /**
     * 构造处理
     * CipherFactory constructor.
     * @param string $key
     * @param string $mixed
     * @param bool $compatible
     */
    public function __construct(string $key, string $mixed, bool $compatible)
    {
        $this->key = str_pad(substr($key, 0, 32), 32, "\0");
        $this->mixed = $mixed;
        $this->compatible = $compatible;
    }

    /**
     * 生产加密工具
     * @return SymmetricKey
     */
    private function factoryCipher(): SymmetricKey
    {
        if (!$this->compatible) {
            $cipher = new ChaCha20();
            $cipher->setKey($this->key);
            $nonce = str_pad(substr($this->mixed, 0, 8), 8, "\0");
            $cipher->setNonce($nonce);
        } else {
            $cipher = new AES('cbc');
            $cipher->setKey($this->key);
            $iv = str_pad(substr($this->mixed, 0, 16), 16, "\0");
            $cipher->setIV($iv);
        }
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
        if ($auto_conver && stringy($data)->isJson()) {
            return json_decode($data, true);
        }
        return $data;
    }
}