<?php
require_once 'text_block_view_element.php';
class FooterElement extends TextBlockViewElement
{
	public function __construct(string $copyright, string $wrapper)
	{
		parent::__construct($copyright, $wrapper);
	}
}