<?php
require_once SRC.'interfaces/i_html_element.php';
class BaseElement implements iView
{
	public function show() : void
	{
		echo  __CLASS__.": I'm an element!<br />";
	}
}
