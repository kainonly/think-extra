<?php
declare(strict_types=1);

namespace tests;

use Exception;
use Lcobucci\JWT\Token;
use think\extra\contract\TokenInterface;
use think\extra\service\TokenService;

class TokenTest extends BaseTest
{
    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * @var string
     */
    private $scene;

    /**
     * @var string
     */
    private $jti;

    /**
     * @var string
     */
    private $ack;

    /**
     * @var array
     */
    private $symbol;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(TokenService::class);
        $this->token = $this->app->get(TokenInterface::class);
        $this->scene = 'default';
        $this->jti = 'test';
        $this->ack = md5('test');
        $this->symbol = [
            'role' => '*'
        ];
    }

    public function testCreate()
    {
        $token = $this->token->create(
            $this->scene,
            $this->jti,
            $this->ack,
            $this->symbol
        );
        $this->assertNotEmpty((string)$token, '令牌创建失败');
        return (string)$token;
    }

    /**
     * @depends testCreate
     */
    public function testGet(string $tokenString)
    {
        $token = $this->token->get($tokenString);
        $this->assertInstanceOf(Token::class, $token);
        $this->assertEquals($this->jti, $token->getClaim('jti'));
    }

    /**
     * @depends testCreate
     */
    public function testVerify(string $tokenString)
    {
        try {
            $result = $this->token->verify('default', $tokenString);
            $this->assertIsBool($result->expired, '未生成超时状态');
            $this->assertInstanceOf(Token::class, $result->token, '令牌信息获取失败');
            $this->assertEquals($this->jti, $result->token->getClaim('jti'));
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

}