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
        * 添加文章 - 字符串
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
        if($res = 'OK'){
            $data = ['status'=>true,'data'=>'添加成功！'];
        }else{
            $data = ['status'=>false,'data'=>'post:'.$postId.':data'.' 已经存在！'];
        }
        return $data;
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
            $data = ['status'=>false,'data'=>'文章 post:'.$id.':data 不存在！'];
        }else{
            // 序列化文章存储
            $data = ['status'=>true,'data'=>unserialize($res)]; 
        }
        return $data;
    }

    /**
        * 添加文章 - 散列 - 解决字符串序列存储导致的内存浪费/单一字段修改的竞态问题
        * @param  [arr] $data
        * @author xu
        * @copyright 2018-06-04
    */
    function addArt($data)
    {
        $client = $this->client;

        // 获取自增ID
        $postId = $client->incr('post:count'); 
        // foreach ($data as $k => $v){
        //     $client->hset('post:'.$postId.':data',$k,$v);
        // }
        echo $postId;
        $client->hmset('post:'.$postId.':data',$data);
        return ['status'=>true,'data'=>'success'];
    }

    /**
     * 读取文章 -散列
    */
    function getArt($id,$field='all')
    {
        $client = $this->client;

        if($field=='all') {
            $data = $client->hgetall('post:'.$id.':data');
        }else{
            $data = $client->hget('post:'.$id.':data',$field);
        }
        return ['status'=>true,'data'=>$data];
    }

    /**
     * 编辑文章 -散列
    */
    function setArt($id,$data)
    {
        $client = $this->client;
        foreach ($data as $k => $v) {
            $client->hset('post:'.$id.':data',$k,$v);
        }
        return ['status'=>true,'data'=>true];
    }


    /**
     * 删除文章 -散列
    */
    function delArt($id)
    {
        $client = $this->client;
        $data = ['title','content','author','time'];
        $client->hdel('post:'.$id.':data',$data);
        return ['status'=>true,'data'=>true];
    }


}