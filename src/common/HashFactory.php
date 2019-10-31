<?php
declare (strict_types=1);

namespace think\extra\common;

use think\extra\contract\HashInterface;

/**
 * HASH 操作类
 * Class HashFactory
 * @package think\extra\common
 */
final class HashFactory implements HashInterface
{
    /**
     * 加密算法
     * @var int
     */
    private $algo;

    /**
     * 加密配置
     * @var array
     */
    private $options;

    /**
     * 构造处理
     * HashFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->algo = $this->getAlgo($config['driver']);
        $this->options = !empty($config[$this->algo]) ? $config[$this->algo] : [];
    }

    /**
     * 获取加密算法
     * @return int
     */
    private function getAlgo(string $type)
    {
        switch ($type) {
            case 'argon2id':
                return PASSWORD_ARGON2ID;
            case 'argon2i':
                return PASSWORD_ARGON2I;
            case 'bcrypt':
                return PASSWORD_BCRYPT;
            default:
                return PASSWORD_ARGON2I;
        }
    }

    /**
     * @param string $password
     * @param array $options
     * @return false|string
     * @inheritDoc
     */
    public function create(string $password, array $options = [])
    {
        return password_hash(
            $password,
            $this->algo,
            !empty($options) ? $options : $this->options
        );
    }

    /**
     * @param string $password
     * @param string $hashPassword
     * @return bool
     * @inheritDoc
     */
    public function check(string $password, string $hashPassword)
    {
        return password_verify($password, $hashPassword);
    }
}