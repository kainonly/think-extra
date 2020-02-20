<?php
declare (strict_types=1);

namespace think\extra\common;

use think\extra\contract\JumpInterface;
use think\Request;

/**
 * 工具生产类
 * Class UtilsFactory
 * @package think\extra\common
 */
class JumpFactory implements JumpInterface
{
    private $request;
    private $options;

    public function __construct(Request $request, array $option)
    {
        $this->request = $request;
        $this->options = $option;
    }
}