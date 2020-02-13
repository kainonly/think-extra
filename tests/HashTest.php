<?php
declare(strict_types=1);

namespace ExtraTests;

use Tests\BaseTest;
use think\extra\contract\HashInterface;
use think\extra\service\HashService;

class HashTest extends BaseTest
{
    /**
     * @var HashInterface
     */
    private $hash;

    /**
     * @var string
     */
    private $password;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(HashService::class);
        $this->hash = $this->app->get(HashInterface::class);
        $this->password = 'mypassword';
    }

    public function testCreateHash()
    {
        $hashContext = $this->hash->create($this->password);
        $this->assertNotEmpty(
            $hashContext,
            '哈希密码创建失败'
        );
        return $hashContext;
    }

    /**
     * @depends testCreateHash
     */
    public function testCheckHash(string $context)
    {
        $this->assertTrue(
            $this->hash->check($this->password, $context),
            '密码验证失败'
        );
    }
}