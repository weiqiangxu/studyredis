<?php

// 文章列表
$article = new article();

// 添加文章-序列化
$data = [   
        'title'=>'东方不败',
        'content'=>'打不过的时候想想，同学你充钱了吗？',
        'author'=>'马化腾',
        'time'=>time()
    ];
$res = $article->addArticle($data);


// 读取文章-字符串
$res = $article->getArticle(16);

// 添加文章-散列
$data = [   
        'title'=>'东方不败',
        'content'=>'打不过的时候想想，同学你充钱了吗？',
        'author'=>'马化腾',
        'time'=>time()
    ];
$res = $article->addArt($data);

// 读取文章
$res = $article->getArt(52,'title');

// 编辑文章
$res = $article->setArt(38,['title'=>'大王叫我来巡山']);

// 删除文章
$res = $article->delArt(38);
var_dump($res);
// 读取文章
$res = $article->getArt(58);
var_dump($res);