<?php
declare (strict_types=1);

namespace think\extra\common;

use InvalidArgumentException;
use stdClass;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use think\extra\contract\TokenInterface;

/**
 * 令牌操作类
 * Class JwtFactory
 * @package think\extra\common
 */
class TokenFactory implements TokenInterface
{
    /**
     * 令牌配置
     * @var array $config
     */
    private array $options;

    /**
     * 令牌密钥
     * @var string $secret
     */
    private string $secret;

    /**
     * 构造处理
     * @param string $secret 令牌密钥
     * @param array $options 令牌配置
     */
    public function __construct(string $secret, array $options)
    {
        $this->secret = $secret;
        $this->options = $options;
    }

    /**
     * @param string $scene
     * @param string $jti
     * @param string $ack
     * @param array $symbol
     * @return Token
     * @inheritDoc
     */
    public function create(string $scene, string $jti, string $ack, array $symbol = []): Token
    {
        if (empty($this->options[$scene])) {
            throw new InvalidArgumentException("The [$scene] does not exist.");
        }

        return (new Builder())
            ->issuedBy($this->options[$scene]['issuer'])
            ->permittedFor($this->options[$scene]['audience'])
            ->identifiedBy($jti, true)
            ->withClaim('ack', $ack)
            ->withClaim('symbol', $symbol)
            ->expiresAt(time() + $this->options[$scene]['expires'])
            ->getToken(new Sha256(), new Key($this->secret));
    }

    /**
     * @param string $tokenString
     * @return Token
     * @inheritDoc
     */
    public function get(string $tokenString): Token
    {
        return (new Parser())->parse($tokenString);
    }

    /**
     * @param string $scene
     * @param string $tokenString
     * @return stdClass
     * @throws InvalidArgumentException
     * @inheritDoc
     */
    public function verify(string $scene, string $tokenString): stdClass
    {
        $token = (new Parser())->parse($tokenString);
        if (!$token->verify(new Sha256(), $this->secret)) {
            throw new InvalidArgumentException('Token validation is incorrect');
        }

        if ($token->getClaim('iss') !== $this->options[$scene]['issuer'] ||
            $token->getClaim('aud') !== $this->options[$scene]['audience']) {
            throw new InvalidArgumentException('Token information is incorrect');
        }

        $result = new stdClass();
        $result->expired = $token->isExpired();
        $result->token = $token;
        return $result;
    }
}