<?php
declare(strict_types=1);

namespace ExtraTests;

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
    private string $password = 'mypassword';

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(HashService::class);
        $this->hash = $this->app->get(HashInterface::class);
    }

    public function testCreateHash(): string
    {
        $hashPassword = $this->hash->create($this->password);
        self::assertNotEmpty($hashPassword, '哈希密码创建失败');
        return $hashPassword;
    }

    /**
     * @depends testCreateHash
     * @param string $hashPassword
     */
    public function testCheckHash(string $hashPassword): void
    {
        $password = $this->hash->check($this->password, $hashPassword);
        self::assertTrue($password, '密码验证失败');
    }
}