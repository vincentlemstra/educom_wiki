<?php
require_once 'siteDAO.php';
require_once 'formview.class.php';

$page = 'article';
$sitedao = new SiteDAO;
$forminfo = $sitedao->getFieldInfoByPage($page);
//print_r($fieldinfo);

$formclass = new FormElement($forminfo);
$formclass->show();
