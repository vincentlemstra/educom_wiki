<?php
Require_once SRC.'interfaces/i_Html_element.php';
class ShowMessage implements iView
{
    //protected SYSMSG;
    //protected SYSERR;
    public function __construct ($response)
    {
        $this->response = $response;
    }

    public function show() : void
    {
        
        foreach ([SYSERR,SYSMSG] as $key)
        {  
            $msg = Tools::getValueFromArray($key, $this->response,'');
            if ($msg)
            {
                echo '<div class="'.$key.'">'.PHP_EOL
                    .$msg.PHP_EOL
                    .'</div>'.PHP_EOL;
            }    
        }    
    }
}