<?php
declare(strict_types=1);

namespace testing;

use PHPUnit\Framework\TestCase;
use think\App;
use think\extra\common\HashFactory;
use think\extra\contract\HashInterface;
use think\extra\service\HashService;


class HashTest extends TestCase
{
    private $password = 'asdf1234';

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
        $app->register(HashService::class);
        $hash = $app->get(HashInterface::class);
        $this->assertInstanceOf(
            HashFactory::class,
            $hash,
            '应用服务注册失败'
        );
        return $hash;
    }

    /**
     * @param HashInterface $hash
     * @depends testRegisterService
     */
    public function testCreateHash(HashInterface $hash)
    {
        $params = new \stdClass();
        $params->hash = $hash;
        $params->context = $hash->create($this->password);
        $this->assertNotEmpty(
            $params->context,
            '哈希密码创建失败'
        );
        return $params;
    }

    /**
     * @param \stdClass $params
     * @depends testCreateHash
     */
    public function testCheckHash(\stdClass $params)
    {
        /**
         * @var HashInterface $hash
         * @var string $context
         */
        $hash = $params->hash;
        $context = $params->context;
        $this->assertTrue(
            $hash->check($this->password, $context),
            '密码验证失败'
        );
    }
}