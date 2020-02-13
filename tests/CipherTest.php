<?php
declare(strict_types=1);

namespace ExtraTests;

use Tests\BaseTest;
use think\extra\contract\CipherInterface;
use think\extra\service\CipherService;

class CipherTest extends BaseTest
{
    /**
     * @var CipherInterface
     */
    private $cipher;

    /**
     * @var array
     */
    private $data = [
        'name' => 'kain'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(CipherService::class);
        $this->cipher = $this->app->get(CipherInterface::class);
    }

    /**
     * @return string
     */
    public function testEncrypt()
    {
        $context = $this->cipher->encrypt($this->data);
        $this->assertNotEmpty($context, '加密不成功');
        return $context;
    }

    /**
     * @param string $context
     * @depends testEncrypt
     */
    public function testDecrypt(string $context)
    {
        $result = $this->cipher->decrypt($context);
        $this->assertEquals($this->data, $result, '解密信息不对称');
    }
}