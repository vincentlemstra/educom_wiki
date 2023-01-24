<?php
require_once SRC.'interfaces/i_html_element.php';
class BaseElement //implements iHtmlDoc
{
	public function show() : void
	{
		echo  __CLASS__.": I'm an element!<br />";
	}
}
