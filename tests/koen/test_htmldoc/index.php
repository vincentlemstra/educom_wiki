<?php
require_once 'config.php';
require_once 'html_doc.php';
require_once 'menuview.php';
require_once 'text_block_view_element.php';
require_once 'footer_element.php';
require_once 'siteDAO.php';
require_once 'footer_element.php';

$page = 'about';
$siteDAO = new SiteDAO();
$menu = $siteDAO->getMenuItems();
$bodycontent = $siteDAO->getTextByPage($page, 'div');
$title = 'Wiki Page';
$footer = '&copy; '.date("Y").'&nbsp;';

$response = new Htmldoc();
$response->setTitle($title);//get application siteDAO title data
$response->addElement(new MenuView($menu));//get application siteDAO menu data
$response->addElement(new TextBlockViewElement($bodycontent , 'div class="wrapper"'));//get application siteDAO page tekst
$response->addElement(new FooterElement($footer, 'footer'));//get application footer data
$response->addCssFile('style.css');
$response->show();
