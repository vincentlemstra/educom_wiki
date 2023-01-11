<?php
require_once 'baselist.class.php';
class AuthorListView extends Baselist
{
	public function openList()
	{
		echo '<DIV class="authorlist-container"><DIV class="authorlist-item"><UL>';
	}

	public function showItem(array $item)
	{
		echo '<LI><A href="index.php?author='.$item['id'].'" id="'.$item['id'].'">'.$item['name'].'</A></LI>';
	}
	
	public function closeList()
	{
		echo "</UL></DIV></DIV>";
	}
}