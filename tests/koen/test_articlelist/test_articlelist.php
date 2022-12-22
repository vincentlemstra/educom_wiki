<?php
require_once 'siteDAO.php';
require_once 'articlelistview.php';

$sitedao = new siteDAO();
$list = $sitedao->getArticles();

//var_dump($list);

$articleview = new ArticleListView($list);
$articleview->show();