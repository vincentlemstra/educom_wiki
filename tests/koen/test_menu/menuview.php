<?php
require_once 'baselist.class.php';

class MenuView extends BaseList 
{
	public function openList()
	{
		echo "<NAV><UL>";
	}
	
	public function showItem(string $key, string $value)
	{
		echo '<LI><A href="index.php?page="'.$key.'>'.$value.'</A></LI>';
	}
	
	public function closeList()
	{
		echo "	</UL></NAV>";
	}
}
