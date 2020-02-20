<?php
declare(strict_types=1);

namespace ExtraTests;

use Exception;
use Ramsey\Uuid\Uuid;
use Stringy\Stringy;
use Tests\BaseTest;

class HelperTest extends BaseTest
{
    public function testUuid()
    {
        try {
            $uuid = \uuid();
            $this->assertInstanceOf(Uuid::class, $uuid);
            $this->assertNotEmpty($uuid->toString());
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testStringy()
    {
        $stringy = \stringy('hello');
        $this->assertInstanceOf(Stringy::class, $stringy);
        $this->assertEquals('e', $stringy->at(1));
    }
}