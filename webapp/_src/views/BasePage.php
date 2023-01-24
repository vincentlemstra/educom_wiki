<?php
/**
 * Hmtl Base Page using Binary Tree mechanism 
 * for managing its head and body elements 
 *
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
require_once SRC.'interfaces/iElementPage.php';
require_once SRC.'views/BasePageElement.php';
class BasePage implements iElementPage
{
    private string $title;
    private string $doc_open_string;
    private $header_elements = null;
    private $body_elements = null;
//==============================================================================
    public function __construct(string $title, string $doc_open_string='<!DOCTYPE html><html>')
    {
        $this->title = $title;
        $this->doc_open_string = $doc_open_string;
    }
//==============================================================================
    final public function show() : void
    {
        echo $this->doc_open_string.PHP_EOL
            .'  <head>'.PHP_EOL
            .'      <title>'.$this->title.'</title>'.PHP_EOL
            .'      <meta charset="utf-8">'.PHP_EOL
            .'      <meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL
            .'      <meta name="viewport" content="width=device-width, initial-scale=1">'.PHP_EOL
            .'      <meta name="author" content="'.AUTHOR.'" />'.PHP_EOL
            .'      <link rel="author" href="'.AUTHOR_URL.'" />'.PHP_EOL;
        if ($this->header_elements)
        {
            $this->header_elements->show();
        }
        echo '</head>'.PHP_EOL
            .'<body>'.PHP_EOL;
        $this->_startBody();
        if ($this->body_elements)
        {    
            $this->body_elements->show();
        }    
        $this->_endBody();
        echo '  </body>'.PHP_EOL
            .'</html>';
    }
//==============================================================================
    final public function addHeadElement($element) : void
    {
        is_null($this->header_elements) 
        ? $this->header_elements = $element 
        : $this->header_elements->insert($element);
    }
//==============================================================================
    final public function addBodyElement($element) : void
    {
        is_null($this->body_elements) 
        ? $this->body_elements = $element 
        : $this->body_elements->insert($element);
    }
//==============================================================================
    protected function _startBody()
    {
        echo '<div>'.PHP_EOL;
    }
//==============================================================================
    protected function _endBody()
    {
        echo '</div>'.PHP_EOL;
    }
}