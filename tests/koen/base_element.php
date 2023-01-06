<?php
require_once CLASSPATH.'i_html_element.php';
class BaseElement implements iView
{
	public function show()
	{
		echo  __CLASS__.": I'm an element!<br />";
	}
}
