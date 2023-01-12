<?php

require_once 'i_Html_Element.php';
require_once 'articlelistauthor.class.php';

class AuthorPageView implements iView
{
	public function show() : void
    {
    
	// todo logica inbouwen die de author id uit de URL ophaalt en op basis daarvan de juiste id meegeeft bij het aanroepen van deze class
	
	// get author data
	// LET OP: heb voor deze authorpage in de siteDAO een nieuwe functie getAuthor() gemaakt die maar 1 auteur ophaalt ipv alle 4
    $getdata = new SiteDAO();
    $author = $getdata->getAuthor();
	
	// get articles data
	$articles = $getdata->getArticlesByAuthorId();
    
    // todo gebruiken van database om article names op te halen
    // $articleNames = new ArticleModel();
    // $items = $articleNames->getArticleNamesByAuthorId($author['id']);
    // $this->items = $items;
	

	// Author name as title
    echo '<h1>'.$author['name'].'</h1>';

	// author description
    echo '<div class="bodycontent">'.$author['description'].'</div>';

	// list of author's articles
	$list = new ArticleListAuthor($articles);
	echo $list->show();
    }
}