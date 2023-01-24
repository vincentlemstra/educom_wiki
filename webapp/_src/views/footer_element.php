<?php
require_once 'text_block_view_element.php';
class FooterElement extends TextBlockViewElement
{
	public function __construct(int $order, string $copyright, string $wrapper)
	{
		parent::__construct($order, $copyright, $wrapper);
	}
}