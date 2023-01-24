<?php
require_once SRC.'views/BasePageElement.php';
class TextBlockViewElement extends BasePageElement
{
   protected string $text_block;
   
    public function __construct(int $order, string $text_block, string $wrapper)
    {
       parent::__construct($order);
       $this->text_block = $text_block;
       $this->wrapper    = $wrapper;
    }

    public function _displayContent() : string
    {
        return '<'.$this->wrapper.'>'.$this->text_block.'</'.$this->wrapper.'>';
    }
}