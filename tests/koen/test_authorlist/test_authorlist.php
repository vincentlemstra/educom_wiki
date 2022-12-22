<?php
require_once 'siteDAO.php';
require_once 'authorlistview.php';

$siteDAO = new siteDAO();
$list = $siteDAO->getAuthors();

$authorlistview = new AuthorListView($list);
$authorlistview->show();
