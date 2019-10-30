<?php
declare (strict_types=1);

namespace think\extra\common;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

/**
 * 令牌操作类
 * Class JwtFactory
 * @package think\extra\common
 */
final class TokenFactory
{
    /**
     * 令牌配置
     * @var array $config
     */
    private $options;
    /**
     * 令牌密钥
     * @var string $secret
     */
    private $secret;
    /**
     * 令牌签名
     * @var Sha256 $signer
     */
    private $signer;

    /**
     * 构造处理
     * @param string $secret 令牌密钥
     * @param array $options 令牌配置
     */
    public function __construct(string $secret, array $options)
    {
        $this->secret = $secret;
        $this->options = $options;
        $this->signer = new Sha256();
    }

    /**
     * 生成令牌
     * @param string $scene
     * @param string $jti
     * @param string $ack
     * @param array $symbol
     * @return \Lcobucci\JWT\Token|false
     */
    public function create(string $scene, string $jti, string $ack, array $symbol = [])
    {
        return !empty($this->options[$scene]) ? (new Builder())
            ->issuedBy($this->options[$scene]['issuer'])
            ->permittedFor($this->options[$scene]['audience'])
            ->identifiedBy($jti, true)
            ->withClaim('ack', $ack)
            ->withClaim('symbol', $symbol)
            ->expiresAt(time() + $this->options[$scene]['expires'])
            ->getToken($this->signer, new Key($this->secret)) : false;
    }

    /**
     * 获取令牌对象
     * @param string $tokenString
     * @return \Lcobucci\JWT\Token
     */
    public function get(string $tokenString)
    {
        return (new Parser())->parse($tokenString);
    }

    /**
     * 验证令牌
     * @param string $scene
     * @param string $tokenString
     * @return \stdClass
     * @throws \Exception
     */
    public function verify(string $scene, string $tokenString)
    {
        $token = (new Parser())->parse($tokenString);
        if (!$token->verify($this->signer, $this->secret)) {
            throw new \Exception('Token validation is incorrect');
        }

        if ($token->getClaim('iss') != $this->options[$scene]['issuer'] ||
            $token->getClaim('aud') != $this->options[$scene]['audience']) {
            throw new \Exception('Token information is incorrect');
        }

        $result = new \stdClass();
        $result->expired = $token->isExpired();
        $result->token = $token;
        return $result;
    }
}