<?php
//require_once SRC.'interfaces/i_Html_Element.php';
class HtmlDoc //implements iView
{
	protected string $title = "WIKI HTML DOC CLASS";
	protected array	 $elements = array();
    protected array  $cssfiles;
    protected array  $jsfiles;
    protected bool   $js_in_head;
//=============================================================================
// PUBLIC
//=============================================================================
    public function __construct()
    {
        $this->cssfiles = [];
        $this->jsfiles = [];
        $this->js_in_head = true;
    }

    public function addElement($element)
	{
		$this->elements[] = $element;
	}

	public function setTitle($str_value) 
	{ 
		if (!empty($str_value))
		{	
			$this->title = htmlspecialchars($str_value);
		}	
	}

	final public function show() :void
	{
		$this->beginDoc();
		$this->beginHeader();
		$this->headerContent();
		$this->endHeader();
		$this->beginBody();
		$this->bodyContent();
		$this->endBody();
		$this->endDoc();
	}
    
    public function addCssFile(string $cssfile)
    {
        if (!in_array($cssfile, $this->cssfiles))
        {        
            $this->cssfiles[] = $cssfile;
        }        
    } 
//==============================================================================
// Bind JavaScript Files in HEAD  section or at the end of the BODY section     
//==============================================================================
    public function setJsInHead(bool $js_in_head)
    {
        $this->js_in_head = $js_in_head;
    } 
//=============================================================================
// PROTECTED
//=============================================================================
	protected function beginDoc() 
	{ 
		echo '<!DOCTYPE html>'.PHP_EOL.'<html>'.PHP_EOL; 
	}

	protected function headerContent() 
	{ 
		echo '<title>'.$this->title.'</title>'.PHP_EOL; 
        $this->showCssFiles();
	}
	
	protected function bodyContent() 
	{ 
		//Tools::dump($this->elements);
		foreach ($this->elements as $element)
		{
			if ($element instanceof iView)
			{	
				$element->show();
			}  
			else
			{
//  Todo Throw exception!				
				echo 'Error : Cannot show a '.get_class($element).' element.<br />'.PHP_EOL;
			}
		}	
	}
//=============================================================================
// PRIVATE
//=============================================================================
	private function beginHeader() 
	{ 
		echo '<head>'.PHP_EOL; 
	}

	private function endHeader()
	{ 
		echo '</head>'.PHP_EOL; 
	}
	
	private function beginBody() 
	{ 
		echo '<body>'.PHP_EOL; 
	}

	private function endBody() 
	{ 
		echo '</body>'.PHP_EOL; 
	}
	
	private function endDoc() 
	{ 
		echo '</html>'.PHP_EOL; 
	}
//==============================================================================
    private function showCssFiles() 
    {
        foreach ($this->cssfiles as $stylesheet)
        {
            echo '  <link rel="stylesheet" href="'.$stylesheet.'" />'.PHP_EOL;    
        }    
    }    
//==============================================================================
    private function showJsFiles() 
    {
        foreach ($this->jsfiles as $js)
        {
            echo '  <script src="'.$js.'"></script>'.PHP_EOL; 
        }    
    }     
//==============================================================================
}