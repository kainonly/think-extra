<?php
declare (strict_types=1);

namespace think\extra\contract;

use stdClass;
use Exception;
use Lcobucci\JWT\Token\Plain;

interface TokenInterface
{
    /**
     * 生成令牌
     * @param string $scene 配置场景
     * @param string $jti 令牌ID
     * @param string $ack 确认码
     * @param array $symbol claims
     * @return Plain
     */
    public function create(string $scene, string $jti, string $ack, array $symbol = []): Plain;

    /**
     * 获取令牌对象
     * @param string $jwt JWT字符串
     * @return Plain
     */
    public function get(string $jwt): Plain;

    /**
     * 验证令牌
     * @param string $scene 配置场景
     * @param string $jwt JWT字符串
     * @return stdClass {expired:bool 是否过期, token:Token 令牌对象}
     * @throws Exception
     */
    public function verify(string $scene, string $jwt): stdClass;
}