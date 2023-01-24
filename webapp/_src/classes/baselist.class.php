<?php
require_once SRC.'views/BasePageElement.php';
Abstract class BaseList extends BasePageElement
{
protected array $items; //protected--> kan overschreven worden door extends

	public function __construct(int $order, array $items , $page='')
	{
		parent::__construct($order);
		$this->items = $items;
		$this->page = $page;
	}

	final public function _displayContent() : string //in extend niet overschrijfbaar
	{
		$ret  = $this->openList();
		$ret .= $this->showItems();
		$ret .= $this->closeList();
		return $ret;
	}
	
	protected function showItems()
	{
		$ret = '';
		foreach($this->items as $item)
		{
			$ret .= $this->showItem($item, $this->page);
		}
		return $ret;
	}
	abstract function openList();
	abstract function closeList();
}