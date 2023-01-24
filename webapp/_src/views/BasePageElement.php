<?php
/**
 * Hmtl Page Element implementing Binary Tree mechanism
 *
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
require_once SRC.'interfaces/iPageElement.php';
abstract class BasePageElement implements iPageElement
{
    protected /*?\ManKind\cms\interfaces\iPageElement*/ $left = null;
    protected /*?\ManKind\cms\interfaces\iPageElement*/ $right = null;
    protected int $order = 0;
    protected bool $direct_output;
//==============================================================================
    public function __construct(int $order, bool $add_wrapper=true)
    {
        $this->order = $order;
        $this->add_wrapper = $add_wrapper;
    }
//==============================================================================
    final public function insert($newelement) : void
    {
        if ($this->_compareTo($newelement) > 0)
        {
            $this->left == null 
            ? $this->left = $newelement 
            : $this->left->insert($newelement);
        }
        else
        {
            $this->right == null 
            ? $this->right = $newelement 
            : $this->right->insert($newelement);
        }
    }
//==============================================================================
    final public function show(?bool $direct_output = true) : string
    {
        //$this->direct_output = $direct_output;
        $ret = '';
        if ($this->left != null)
        {
            echo '<!--'.get_class($this).' left = '.get_class($this->left).' -->'.PHP_EOL;
            //GW 28-10-2022 $ret .= $this->left->show($direct_output);
	    $ret = $this->left->show($direct_output).$ret;
        }
        if ($direct_output) 
        {    
             echo $this->_displayContent();
        }             
        else
        { 
            $ret .= $this->_displayContent();
        }
        if ($this->right != null)
        {
            $ret .= $this->right->show($direct_output);
        }
        return $ret;
    }
//==============================================================================
    final public function getOrder() : int
    {
        return $this->order;
    }
//==============================================================================
    abstract protected function _displayContent() : string;
//==============================================================================
    private function _compareTo($element) : int
    {
        return ( $this->order <=> $element->getOrder() );
    }
//==============================================================================
}
	