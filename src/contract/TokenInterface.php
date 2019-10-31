<?php
declare (strict_types=1);

namespace think\extra\contract;

interface TokenInterface
{
    /**
     * 生成令牌
     * @param string $scene
     * @param string $jti
     * @param string $ack
     * @param array $symbol
     * @return \Lcobucci\JWT\Token|false
     */
    public function create(string $scene, string $jti, string $ack, array $symbol = []);

    /**
     * 获取令牌对象
     * @param string $tokenString
     * @return \Lcobucci\JWT\Token
     */
    public function get(string $tokenString);

    /**
     * 验证令牌
     * @param string $scene
     * @param string $tokenString
     * @return \stdClass
     * @throws \Exception
     */
    public function verify(string $scene, string $tokenString);
}