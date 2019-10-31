<?php
declare(strict_types=1);

namespace testing;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use think\App;
use think\extra\common\UtilsFactory;
use think\extra\contract\UtilsInterface;
use think\extra\service\UtilsService;

class UtilsTest extends TestCase
{
    public function testNewApp()
    {
        $app = new App();
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
        $app->register(UtilsService::class);
        $utils = $app->get(UtilsInterface::class);
        $this->assertInstanceOf(
            UtilsFactory::class,
            $utils,
            '服务注册失败'
        );
        return $utils;
    }

    /**
     * @param UtilsInterface $utils
     * @throws \Exception
     * @depends testRegisterService
     */
    public function testUuid(UtilsInterface $utils)
    {
        $this->assertInstanceOf(
            Uuid::class,
            $utils->uuid(),
            'UUID 生成失败'
        );
    }
}