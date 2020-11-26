<?php
declare(strict_types=1);

namespace ExtraTests;

use think\extra\contract\CipherInterface;
use think\extra\service\CipherService;

class CipherTest extends BaseTest
{
    /**
     * @var CipherInterface
     */
    private $cipher;

    private array $context = [
        'name' => 'my cipher'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(CipherService::class);
        $this->cipher = $this->app->get(CipherInterface::class);
    }

    public function testEncrypt(): string
    {
        $encryptText = $this->cipher->encrypt($this->context);
        self::assertNotEmpty($encryptText, '加密不成功');
        return $encryptText;
    }

    /**
     * @depends testEncrypt
     * @param string $encryptText
     */
    public function testDecrypt(string $encryptText): void
    {
        $result = $this->cipher->decrypt($encryptText);
        self::assertEquals($this->context, $result, '解密信息不对称');
    }

}