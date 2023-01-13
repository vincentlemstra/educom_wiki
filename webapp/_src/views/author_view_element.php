<?php
require_once SRC.'interfaces/i_Html_Element.php';
require_once CLASSPATH.'articlelist_base.class.php';

class AuthorPageView implements iView
{
	protected $author;
	//protected $article;

	public function __construct(array $author, array $articles)
	{
		$this->author = $author;
		$this->articles = $articles;
	}
    
    public function show() : void
    {
    // Author name as title
    echo '<h1>'.$this->author['firstname'].'</h1>';

	// author Text --> to be added from DB
    echo '<div class="bodycontent"> Here is is some dummy data about this great Developer :-) </div>';
	if($_SESSION['UNAME'] == $this->author['firstname'])
	{
		echo '<a href="'.LINKBASE.'newarticle"> create new article</a>';
	}
	// list of author's articles
	$list = new ArticleListAuthor($this->articles);
	$list->show();
    }

}