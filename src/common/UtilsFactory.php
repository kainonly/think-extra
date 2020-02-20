<?php
declare (strict_types=1);

namespace think\extra\common;

use think\App;
use think\extra\contract\UtilsInterface;
use think\extra\utils\Jump;
use think\Request;
use think\Route;

/**
 * 工具生产类
 * Class UtilsFactory
 * @package think\extra\common
 */
class UtilsFactory implements UtilsInterface
{
    private Route $route;
    private Request $request;
    private array $options;

    /**
     * UtilsFactory constructor.
     * @param App $app
     * @param array $option
     */
    public function __construct(App $app, array $option)
    {
        $this->route = $app->route;
        $this->request = $app->request;
        $this->options = $option;
    }

    /**
     * @param string $msg
     * @param string $url
     * @param string $type
     * @return Jump
     */
    public function jump(string $msg, string $url = '', string $type = 'html'): Jump
    {
        if (!empty($url)) {
            $url = $this->route->buildUrl($url)->build();
        }
        $dispatch_success_tmpl = $this->options['dispatch_success_tmpl'] ?? app()->getRootPath() . 'vendor/kain/think-extra/src/tpl/dispatch.html';
        $dispatch_error_tmpl = $this->options['dispatch_error_tmpl'] ?? app()->getRootPath() . 'vendor/kain/think-extra/src/tpl/dispatch.html';
        return new Jump($msg, $url, $type, [
            'dispatch_success_tmpl' => $dispatch_success_tmpl,
            'dispatch_error_tmpl' => $dispatch_error_tmpl
        ]);
    }
}