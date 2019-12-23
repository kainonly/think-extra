<?php
declare (strict_types=1);

namespace think\extra\contract;

use Exception;
use stdClass;
use Lcobucci\JWT\Token;

interface TokenInterface
{
    /**
     * 生成令牌
     * @param string $scene
     * @param string $jti
     * @param string $ack
     * @param array $symbol
     * @return Token
     */
    public function create(string $scene, string $jti, string $ack, array $symbol = []): Token;

    /**
     * 获取令牌对象
     * @param string $tokenString
     * @return Token
     */
    public function get(string $tokenString): Token;

    /**
     * 验证令牌
     * @param string $scene
     * @param string $tokenString
     * @return stdClass
     * @throws Exception
     */
    public function verify(string $scene, string $tokenString): stdClass;
}