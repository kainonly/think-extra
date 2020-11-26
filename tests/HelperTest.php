<?php
declare(strict_types=1);

namespace ExtraTests;

use Exception;
use Ramsey\Uuid\Uuid;

class HelperTest extends BaseTest
{
    public function testUuid(): void
    {
        try {
            $uuid = \uuid();
            self::assertInstanceOf(Uuid::class, $uuid);
            self::assertNotEmpty($uuid->toString());
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testStringy(): void
    {
        $stringy = \stringy('hello');
        self::assertEquals('e', $stringy->at(1));
    }
}