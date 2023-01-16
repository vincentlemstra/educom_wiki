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
			$this->showItem($key, $value, $key === $this->page);
		}
	}
//overide baselist class due to key loss ... to be checked
//add Active page check to darken this menu item.. 
	public function showItem(string $key, string $value , bool $active)
	{
		//to do active page test --> no hyperlink
		echo '<LI>'
				.(
					$active
					?'<span class="menuactive">'.$value.'</span>'
					:'<A href="index.php?page='.$key.'">'.$value.'</A>'
				)
				.'</LI>'.PHP_EOL;
	}
	
	public function closeList()
	{
		echo "	</UL></NAV>";
	}
}
