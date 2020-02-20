<?php
declare (strict_types=1);

namespace think\extra\contract;

use think\extra\utils\Jump;

interface UtilsInterface
{
    /**
     * 跳转工具
     * @param string $msg
     * @param string $url
     * @param string $type
     * @return Jump
     */
    public function jump(string $msg, string $url = '', string $type = 'html'): Jump;
}