<?php
declare(strict_types=1);

namespace ExtraTests;

use Tests\BaseTest;
use think\extra\contract\ContextInterface;
use think\extra\service\ContextService;

class ContextTest extends BaseTest
{
    /**
     * @var ContextInterface
     */
    private $context;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(ContextService::class);
        $this->context = $this->app->get(ContextInterface::class);
    }

    public function testContext()
    {
        $start = function () {
            $this->context->set('name', 'abc');
        };
        $start();
        sleep(1);
        $funcGet = function () {
            return $this->context->get('name');
        };
        $result = $funcGet();
        $this->assertEquals('abc', $result, '上下文内容获取失败');
    }
}