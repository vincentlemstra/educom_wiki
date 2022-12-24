<?php
require_once 'siteDAO.php';
require_once 'formview.class.php';

$page = 'search';
$sitedao = new SiteDAO;
$forminfo = $sitedao->getFieldInfoByPage($page);
//print_r($fieldinfo);

$formclass = new FormElement($forminfo);
$formclass->show();
