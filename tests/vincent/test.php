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
// $tags = [1, 6];
// $data = $articleModel->createArticle(3, 'PHP do while loop', NULL, 'The do...while loop - Loops through a block of code once, and then repeats the loop as long as the specified condition is true.', 'do { code to be executed; } while (condition is true);', $date, $tags);
// var_dump($data);
// echo '<br><br>';



