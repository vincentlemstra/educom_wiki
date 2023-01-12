<?php
require_once SRC.'interfaces/i_html_element.php';
Abstract class BaseList implements iView 
{
protected array $items; //protected--> kan overschreven worden door extends

	public function __construct(array $items , $page='')
	{
		$this->items = $items;
		$this->page = $page;
	}

	final public function show() : void //in extend niet overschrijfbaar
	{
		$this->openList();
		$this->showItems();
		$this->closeList();
	}
	
	protected function showItems()
	{
		foreach($this->items as $item)
		{
			$this->showItem($item, $this->page);
		}
	}
	abstract function openList();
	abstract function closeList();
}