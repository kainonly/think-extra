<?php
declare(strict_types=1);

namespace tests;

use Exception;
use think\App;
use Ramsey\Uuid\Uuid;
use Stringy\Stringy;
use PHPUnit\Framework\TestCase;
use think\extra\common\UtilsFactory;
use think\extra\contract\UtilsInterface;
use think\extra\service\UtilsService;

class UtilsTest extends TestCase
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
     * @depends testRegisterService
     */
    public function testUuid(UtilsInterface $utils)
    {
        try {
            $this->assertInstanceOf(
                Uuid::class,
                $utils->uuid(),
                'uuid version4 创建失败'
            );
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    /**
     * @param UtilsInterface $utils
     * @depends testRegisterService
     */
    public function testStringy(UtilsInterface $utils)
    {
        $this->assertInstanceOf(
            Stringy::class,
            $utils->stringy('hello'),
            'Stringy 创建失败'
        );
    }
}