<?php
require_once "crud/crud.php";
$crud = new Crud();

require_once "article.model/article.model.php";
$articleModel = new ArticleModel($crud);

// --- TESTS ---
echo '<h1>Test page</h1>';

// $data = $articleModel->getArticleById(2);
// var_dump($data);

// $data = $articleModel->getTagsByArticleId(3);
// var_dump($data);

// $data = $articleModel->getArticleAuthorById(2);
// var_dump($data);

$data = $articleModel->getArticlesBySearch([], [1, 2]);
print_r($data);

// $data = $articleModel->getArticleNamesByAuthorId(3);
// var_dump($data);

// $data = $articleModel->getAllTags();
// var_dump($data);

// date_default_timezone_set('Europe/Amsterdam');
// $date = date('Y-m-d H:i:s');
// $tags = [1, 2];
// $data = $articleModel->createArticle(3, 'test', NULL, 'test', 'test', $date, $tags);
// var_dump($data); 

// $tags = [4, 5, 6];
// $data = $articleModel->updateArticleById(29, 'OVERRIDE 3 title', NULL, 'OVERRIDE 3 explanation', 'OVERRIDE 3 code_block', $tags);
// var_dump($data);

// $data = $articleModel->deleteArticleById(9);
// var_dump($data);

// $data = $articleModel->setArticleTags(29, [3, 4]);
// var_dump($data);

// $data = $articleModel->deleteArticleTags(29);
// var_dump($data);