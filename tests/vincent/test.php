<?php

echo '<h1>Test page</h1>';

require_once "crud/crud.php";
$crud = new Crud();

require_once "article.dao/article.dao.php";
$articleModel = new ArticleDAO($crud);

// $data = $articleModel->getArticleById(2);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->getTagsByArticleId(3);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->getArticleAuthorById(2);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->getArticlesBySearch([1], []);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->getArticleNamesByAuthorId(2);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->getAllTags();
// var_dump($data);
// echo '<br><br>';

// date_default_timezone_set('Europe/Amsterdam');
// $date = date('Y-m-d H:i:s');
// $tags = [1, 2];
// $data = $articleModel->createArticle(3, 'test', NULL, 'test', 'test', $date, $tags);
// var_dump($data);
// echo '<br><br>';    

$tags = [4, 5, 6];
$data = $articleModel->updateArticleById(29, 'OVERRIDE 3 title', NULL, 'OVERRIDE 3 explanation', 'OVERRIDE 3 code_block', $tags);
var_dump($data);
echo '<br><br>';

// $data = $articleModel->deleteArticleById(9);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->setArticleTags(29, [3, 4]);
// var_dump($data);
// echo '<br><br>';

// $data = $articleModel->deleteArticleTags(29);
// var_dump($data);
// echo '<br><br>';
