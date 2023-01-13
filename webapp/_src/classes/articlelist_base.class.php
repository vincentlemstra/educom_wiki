<?php
require_once SRC.'classes/baselist.class.php';

class ArticleListAuthor extends Baselist
{
    public function openList()
    {
        echo '<DIV><UL>';
    }

    public function showItems()
    {
       
        foreach($this->items as $item)
		{
            $this->showItem($item);
		}
    }

    public function closeList()
    {
        echo "</UL></DIV>";
    }
    
    protected function showItem(array $item)
	{
		echo '<LI><a href="index.php?page=article&article_id='.$item['id'].'">'.$item['title'].'</a>
				</LI>';
	}
}