<?php
require_once SRC.'interfaces/i_Html_Element.php';
class TextBlockViewElement implements iView
{
   protected string $text_block;
   
    public function __construct(string $text_block, string $wrapper)
    {
       $this->text_block= $text_block;
       $this->wrapper= $wrapper;
    }

    public function show() : void
    {
        echo '<'.$this->wrapper.'>'.$this->text_block.'</'.$this->wrapper.'>';
    }
}