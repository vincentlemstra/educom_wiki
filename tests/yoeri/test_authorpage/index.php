<?php
require_once 'config.php';
require_once 'html_doc.php';
require_once 'menuview.php';
require_once 'text_block_view_element.php';
require_once 'footer_element.php';
require_once 'siteDAO.php';
require_once 'authorpageview.php';

function createWikiDoc()
{
	$page = 'author';
	$siteDAO = new SiteDAO();
	$menu = $siteDAO->getMenuItems();
	$title = 'Wiki Page';
	$footer = '&copy; '.date("Y").'&nbsp;';
	$response = new Htmldoc();
	$response->setTitle($title); //get application siteDAO title data
	$response->addElement(new MenuView($menu));//get application siteDAO menu data
	$response->addElement(new AuthorPageView($siteDAO->getAuthor()), 'div class="wrapper"');//get application siteDAO page tekst
	$response->addElement(new FooterElement($footer, 'footer'));//get application footer data
	$response->addCssFile('style.css');
	return $response;
}
$response = createWikidoc();
$response->show();

