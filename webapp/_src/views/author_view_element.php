<?php
require_once CLASSPATH.'articlelist_base.class.php';
require_once 'BasePageElement.php';

class AuthorPageView extends BasePageElement implements iPageElement
{
	protected $author;
	protected $article;

	public function __construct(int $order, array $author) 
	{
		parent::__construct($order);
		$this->author = $author;
	}
    
    public function _displayContent() : string
    {
    // Author name as title
    $ret = '<h1>'.$this->author['firstname'].'</h1>';

	// author Text --> to be added from DB
    $ret .= '<div class="bodycontent"> Here is is some dummy data about this great Developer :-) </div>';
	if($_SESSION['UNAME'] == $this->author['firstname'])
	{
		$ret .= '<a href="'.LINKBASE.'newarticle"> create new article</a>';
	}
	return $ret;
    }

	

}