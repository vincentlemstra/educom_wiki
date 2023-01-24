<?php
require_once 'BasePageElement.php';
class ShowMessage extends BasePageElement /*implements iView*/
{
    public function __construct (int $order, array $response, bool $add_wrapper = true)
    {
        parent::__construct($order, $add_wrapper);
        $this->response = $response;
    }

    public function _displayContent() : string
    {
        $ret = '';
        foreach ([SYSERR,SYSMSG] as $key)
        {  
            $msg = Tools::getValueFromArray($key, $this->response,'');
            if ($msg)
            {
               if(empty($ret))
               {
               $ret = '<div class="'.$key.'">'.PHP_EOL
                    .$msg.PHP_EOL
                    .'</div>'.PHP_EOL;
                }
                else 
                {
                     $ret .= '<div class="'.$key.'">'.PHP_EOL
                    .$msg.PHP_EOL
                    .'</div>'.PHP_EOL;
                }
            }
           
        }
        return $ret;     
    }
}