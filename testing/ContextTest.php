<?php
declare(strict_types=1);

namespace testing;

use PHPUnit\Framework\TestCase;
use think\App;
use think\extra\common\ContextFactory;
use think\extra\contract\ContextInterface;
use think\extra\service\ContextService;

class ContextTest extends TestCase
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
        $app->register(ContextService::class);
        $context = $app->get(ContextInterface::class);
        $this->assertInstanceOf(
            ContextFactory::class,
            $context,
            '服务注册失败'
        );
        return $context;
    }

    /**
     * @param ContextInterface $context
     * @depends testRegisterService
     */
    public function testContext(ContextInterface $context)
    {
        $context->set('name', 'abc');
        $this->assertEquals('abc', $context->get('name'));
    }
}