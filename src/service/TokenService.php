<?php
declare (strict_types=1);

namespace think\extra\service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use think\extra\common\TokenFactory;
use think\extra\contract\TokenInterface;
use think\Service;

class TokenService extends Service
{
    public function register(): void
    {
        $this->app->bind(TokenInterface::class, function () {
            $config = $this->app->config;
            return new TokenFactory(
                Configuration::forSymmetricSigner(
                    new Sha256(),
                    InMemory::plainText($config->get('app.app_secret'))
                ),
                $config->get('token')
            );
        });
    }
}