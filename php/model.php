<?php

/**
 * 接口
 */
class article
{
    private  $client;


    /**
        * 客户端连接
        * @author xu
        * @copyright 2018-06-04
    */
    function __construct() {
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        $this->client = $client;
    }


    /**
        * 添加文章
        * @param  [arr] $data
        * @author xu
        * @copyright 2018-06-04
    */
    function addArticle($data)
    {
        $client = $this->client;
        // 获取自增ID
        $postId = $client->incr('post:count'); 
        // 序列化文章存储
        $serializePost = serialize($data);

        $res = $client->set('post:'.$postId.':data', $serializePost);
        
        if($res = 'OK')
        {
            $data = '添加成功！';
        }
        else
        {
            $data = 'post:'.$postId.':data'.' 已经存在！';
        }

        return ['status'=>true,'data'=>$data];
    }


    /**
        * 获取文章
        * @param  [int] $id
        * @author xu
        * @copyright 2018-06-04
    */
    function getArticle($id)
    {
        $client = $this->client;
        $res = $client->get('post:'.$id.':data');
        
        if(empty($res)) {
            $data = '文章 post:'.$id.':data 不存在！';
        }else{
            // 序列化文章存储
            $data = unserialize($res); 
        }
        return ['status'=>true,'data'=>$data];
    }

}