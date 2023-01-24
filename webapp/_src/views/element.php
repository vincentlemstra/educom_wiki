<?php
require_once 'BasePageElement.php';
class Element extends BasePageElement
{
protected $content;

  public function __construct(int $order, string $content, bool $add_wrapper=true)
  {
  	parent::__construct($order, $add_wrapper);
  	$this->content = $content;
  }
	 protected function _displayContent() : string
	 {
	 	return $this->content;
	 }
}