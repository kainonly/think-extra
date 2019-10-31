<?php
declare(strict_types=1);

namespace testing;

use Lcobucci\JWT\Token;
use PHPUnit\Framework\TestCase;
use think\App;
use think\extra\common\TokenFactory;
use think\extra\contract\TokenInterface;
use think\extra\service\TokenService;

class TokenTest extends TestCase
{
    /**
     * @return App
     */
    public function testNewApp()
    {
        $app = new App();
        $app->initialize();
        $this->assertInstanceOf(
            App::class,
            $app,
            '应用容器创建失败'
        );
        return $app;
    }

    /**
     * @param App $app
     * @return object
     * @depends testNewApp
     */
    public function testRegisterService(App $app)
    {
        $params = new \stdClass();
        $app->register(TokenService::class);
        $params->tokenFactory = $app->get(TokenInterface::class);
        $this->assertInstanceOf(
            TokenFactory::class,
            $params->tokenFactory,
            '服务注册失败'
        );

        return $params;
    }

    /**
     * @param \stdClass $params
     * @depends testRegisterService
     */
    public function testCreate(\stdClass $params)
    {
        /**
         * @var TokenInterface $tokenFactory
         */
        $tokenFactory = $params->tokenFactory;
        $token = $tokenFactory->create('default', 'xxx-xxx-xxx', 'abc', [
            'role' => '*'
        ]);
        $this->assertInstanceOf(Token::class, $token, '令牌创建失败');
        $params->token = (string)$token;
        return $params;
    }

    /**
     * @param \stdClass $params
     * @depends testCreate
     */
    public function testGet(\stdClass $params)
    {
        /**
         * @var TokenInterface $tokenFactory
         */
        $tokenFactory = $params->tokenFactory;
        $this->assertInstanceOf(
            Token::class,
            $tokenFactory->get($params->token),
            '令牌信息获取失败'
        );
    }

    /**
     * @param \stdClass $params
     * @throws \Exception
     * @depends testCreate
     */
    public function testVerify(\stdClass $params)
    {
        /**
         * @var TokenInterface $tokenFactory
         */
        $tokenFactory = $params->tokenFactory;
        $result = $tokenFactory->verify('default', $params->token);
        $this->assertIsBool($result->expired, '未生成超时状态');
        $this->assertInstanceOf(Token::class, $result->token, '令牌信息获取失败');
    }

}