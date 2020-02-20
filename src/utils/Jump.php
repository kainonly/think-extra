<?php
declare (strict_types=1);

namespace think\extra\utils;

use think\Response;

class Jump
{
    private array $body = [
        'msg' => null,
        'url' => null,
        'data' => [],
        'wait' => 3
    ];
    private string $type;
    private array $header = [];
    private array $options = [];

    public function __construct(string $msg, string $url, string $type, array $options)
    {
        $this->body['msg'] = $msg;
        $this->body['url'] = $url;
        $this->type = $type;
        $this->options = $options;
    }

    public function setData(array $value): self
    {
        $this->body['data'] = $value;
        return $this;
    }

    public function setWait(int $value): self
    {
        $this->body['wait'] = $value;
        return $this;
    }

    public function setHeader(array $value): self
    {
        $this->header = $value;
        return $this;
    }

    protected function result(int $error, string $template): Response
    {
        $body = array_merge($this->body, [
            'error' => $error
        ]);

        if ($this->type === 'json') {
            return json($body)->header($this->header);
        }

        return view($template, $body)->header($this->header);
    }

    public function success(): Response
    {
        return $this->result(0, $this->options['dispatch_success_tmpl']);
    }

    public function error(): Response
    {
        return $this->result(1, $this->options['dispatch_error_tmpl']);
    }

}