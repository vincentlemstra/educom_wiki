<?php
require_once CLASSPATH.'baselist.class.php';
class MenuView extends BaseList
{
	public function openList()
	{
		return "<NAV><UL>";
	}
	
	public function showItems()
	{	
		$ret = '';
		foreach($this->items as $key => $value)
		{
			{
				$ret .= $this->showItem($key, $value, $key === $this->page);
			}
	
		}
		return $ret;
	}
//overide baselist class due to key loss ... to be checked
//add Active page check to darken this menu item.. 
	public function showItem(string $key, string $value , bool $active)
	{
		$ret = '<LI>'
				.(
					$active
					?'<span class="menuactive">'.$value.'</span>'
					:'<A href="index.php?page='.$key.'">'.$value.'</A>'
				)
				.'</LI>'.PHP_EOL;
		return $ret;
	}
	
	public function closeList()
	{
		return "</UL></NAV>";
	}
}
