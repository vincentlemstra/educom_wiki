<?php
require_once 'baselist.class.php';
class AuthorListView extends Baselist
{
	public function openList()
	{
		echo "<DIV><UL>";
	}

	public function showItem(array $item)
	{
		echo '<LI><A href="index.php/authors/'.$item['name'].'" id="'.$item['id'].'">'.$item['name'].'</A></LI>';
	}
	
	public function closeList()
	{
		echo "</UL></DIV>";
	}
}