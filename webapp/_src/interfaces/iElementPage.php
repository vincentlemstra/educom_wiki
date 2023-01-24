<?php
/**
 * Interface for Hmtl Page using Binary Tree mechanism 
 * for managing its head and body elements 
 *
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
require_once 'iHtmlDoc.php';
interface iElementPage extends iHtmlDoc
{
	public function addHeadElement(iPageElement $element) : void;
	public function addBodyElement(iPageElement $element) : void;
}