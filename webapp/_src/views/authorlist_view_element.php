<?php
require_once CLASSPATH.'baselist.class.php';
class AuthorListView extends Baselist
{
	public function openList()
	{
		echo '<DIV class="authorlist-container"><h2>Onze auteurs:</h2><UL>';
	}

	public function showItem(array $item)
	{
		echo '<LI><A href="index.php?page=author&id='.$item['id'].'">'.$item['firstname'].'</A></LI>';
	}
	
	public function closeList()
	{
		echo "</UL></DIV></DIV></div>";
	}
}