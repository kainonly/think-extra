<?php
declare(strict_types=1);

namespace tests;

use Exception;
use Ramsey\Uuid\Uuid;
use Stringy\Stringy;
use think\extra\contract\UtilsInterface;
use think\extra\service\UtilsService;

class UtilsTest extends BaseTest
{
    /**
     * @var UtilsInterface
     */
    private $utils;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(UtilsService::class);
        $this->utils = $this->app->get(UtilsInterface::class);
    }

    public function testUuid()
    {
        try {
            $uuid = $this->utils->uuid();
            $this->assertInstanceOf(Uuid::class, $uuid);
            $this->assertNotEmpty($uuid->toString());
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testStringy()
    {
        $stringy = $this->utils->stringy('hello');
        $this->assertInstanceOf(Stringy::class, $stringy);
        $this->assertEquals('e', $stringy->at(1));
    }
}