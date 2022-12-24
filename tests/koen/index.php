<?php
require_once 'config.php';
require_once 'html_doc.php';
require_once 'menuview.php';
require_once 'text_block_view_element.php';
require_once 'footer_element.php';
require_once 'siteDAO.php';
require_once 'footer_element.php';
require_once 'formview.class.php';

$page = 'search';
$siteDAO = new SiteDAO();
$menu = $siteDAO->getMenuItems();
$bodycontent = $siteDAO->getTextByPage($page, 'div');
$title = 'Wiki Page';
$footer = '&copy; '.date("Y").'&nbsp;';
$forminfo = $siteDAO->getFieldInfoByPage($page);
$formElement = new FormElement($forminfo);

$response = new Htmldoc();
$response->setTitle($title);//get application siteDAO title data
$response->addElement(new MenuView($menu));//get application siteDAO menu data
$response->addElement(new FormElement($forminfo));//get application siteDAO page tekst
$response->addElement(new FooterElement($footer, 'footer'));//get application footer data
$response->addCssFile('style.css');
$response->show();
