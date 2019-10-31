<?php
declare(strict_types=1);

namespace testing;

use PHPUnit\Framework\TestCase;
use think\App;
use think\extra\common\CipherFactory;
use think\extra\contract\CipherInterface;
use think\extra\service\CipherService;

class CipherTest extends TestCase
{
    private $data = [
        'name' => 'kain'
    ];

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
        $app->register(CipherService::class);
        $cipher = $app->get(CipherInterface::class);
        $this->assertInstanceOf(
            CipherFactory::class,
            $cipher,
            '服务注册失败'
        );
        return $cipher;
    }

    /**
     * @param CipherInterface $cipher
     * @return \stdClass
     * @depends testRegisterService
     */
    public function testEncrypt(CipherInterface $cipher)
    {
        $params = new \stdClass();
        $params->cipher = $cipher;
        $params->context = $cipher->encrypt($this->data);
        $this->assertNotEmpty($params->context, '加密不成功');
        return $params;
    }

    /**
     * @param \stdClass $params
     * @depends testEncrypt
     */
    public function testDecrypt(\stdClass $params)
    {
        /**
         * @var CipherInterface $cipher
         * @var string $context
         */
        $cipher = $params->cipher;
        $context = $params->context;
        $this->assertEquals($this->data, $cipher->decrypt($context), '解密信息不对称');
    }
}