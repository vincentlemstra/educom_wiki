<?php

echo '<h2>Test page</h2>';

require_once "crud/crud.php";
$crud = new Crud();

require_once "article.model/article.model.php";
$articleModel = new ArticleModel($crud);

// get article by ID:
$data = $articleModel->getArticleById(2);
foreach ($data[0] as $key => $value) {
    echo $key . ': ';
    echo $value . '<br>';
}

// get article by ID for edit:
$data = $articleModel->getArticleByIdForEdit(2);
foreach ($data[0] as $key => $value) {
    echo $key . ': ';
    echo $value . '<br>';
}

