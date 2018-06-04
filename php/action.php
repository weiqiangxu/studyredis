<?php

// 文章列表
$article = new article();

// 添加文章
$data = ['title'=>'东方不败','content'=>'打不过的时候想想，同学你充钱了吗？','author'=>'马化腾','time'=>time()];
$res = $article->addArticle($data);


// 读取文章
$res = $article->getArticle(16);
var_dump($res);die;