<?php

echo 'hello world!';

// require_once "crud.php";
// $crud = new Crud();

require_once "article.model/article.model.php";
$articleModel = new ArticleModel();

print_r($articleModel->getArticleById(2));