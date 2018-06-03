<?php

/**
 * 接口
 */
class articel
{
    private  $client;

    function __construct() {
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        $this->client = $client;
    }
    // 获取文章
    function getart()
    {
        $client = $this->client;
        $client->set('foo', 'bar');
        $value = $client->get('foo');

        var_dump($value);exit;
        return 'article';
    }
}