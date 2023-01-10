<?php
require_once CLASSPATH.'baselist.class.php';

class MenuView extends BaseList implements iView
{
	public function openList()
	{
		echo "<NAV><UL>";
	}
	
	public function showItems()
	{
		foreach($this->items as $key => $value)
		{
			$this->showItem($key, $value);
		}
	}
//overide baselist class due to key loss ... to be checked
//add Active page check to darken this menu item.. 
	public function showItem(string $key, string $value /*,$active*/)
	{
		//to do active page test --> no hyperlink
		echo '<LI><A href="index.php?page='.$key.'">'.$value.'</A></LI>';
	}
	
	public function closeList()
	{
		echo "	</UL></NAV>";
	}
}
