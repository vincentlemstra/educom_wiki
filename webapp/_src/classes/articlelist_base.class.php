<?php
require_once SRC.'classes/baselist.class.php';

class ArticleListAuthor extends Baselist
{
    public function openList()
    {
        return '<DIV><UL>';
    }

    public function showItems()
    {
       $ret ='';
        foreach($this->items as $item)
		{
            $ret .= $this->showItem($item);
		}
        return $ret;
    }

    public function closeList()
    {
        return "</UL></DIV>";
    }
    
    protected function showItem(array $item)
	{
		return '<LI><a href="index.php?page=article&article_id='.$item['id'].'">'.$item['title'].'</a>
				</LI>';
	}
}