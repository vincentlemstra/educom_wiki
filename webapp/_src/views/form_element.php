<?php
///=============================================================================
// FILE : form_element.php - form-element extending the base element :
//=============================================================================
require_once CLASSPATH.'baselist.class.php';
class FormElement extends BaseList
{
	protected array $forminfo;
	protected array $postresult;

	public function __construct(int $order, array $forminfo, array $fieldinfo, ?array $postresult=[])
	{
        $this->forminfo 	= $forminfo;
        $this->fieldinfo    = $fieldinfo;
		$this->postresult 	= $postresult;
        parent::__construct($order, $this->forminfo);
	}
//==============================================================================	
	public function openList()
	{
        $page = $this->getValueFromArray('page', $this->forminfo, 'NOTSET');
        $action = $this->getValueFromArray('action', $this->forminfo, '');
        $method = $this->getValueFromArray('method', $this->forminfo, 'POST');
        return '<form action="'.$action.'" method="'.$method.'" enctype="multipart/form-data" >
              <input type="hidden" name="page" value="'.$page.'" />';
	}
//==============================================================================
	public function showItems()
	{
        $ret = null;
        foreach ($this->fieldinfo as $name => $info)
        {
            $current_value = $this->getFieldValue($name, $info);
            $ret .= '<label for="'.$name.'">'.$info['label'].'</label>';

            switch ($info['type'])
            {
                case "textarea" :
                    $ret.= $this->showTextArea($name, $info,$current_value);
                    break;
                case "select" :
                    $ret .= $this->showSelect($name, $info,$current_value);
                    break;
                case "select multiple" :
                    $ret .= $this->showSelectmultiple($name, $info,$current_value);
                    break;
                default :   
                    $ret .= $this->showInputField($name, $info, $current_value);
                    break;
            }
            $ret .= '';
            if (isset($this->postresult[$name.'_err']))
            {
                    $ret .=  '<span class="error">* '.$this->postresult[$name.'_err'].'</span><br/>';
            }           
        }
        return $ret;
	}
//==============================================================================
    protected function getFieldValue(string $name, array $info) : string   
    {
        if (isset($this->postresult[$name])) 
        {
            return $this->postresult[$name] ;
        }
        else
        {
            return $this->getValueFromArray('default', $info,'');
        }    
    }    
//==============================================================================
	public function closeList()
	{
		$submit = $this->getValueFromArray('submit', $this->forminfo, 'Submit');
        return '  <button type="submit" value="submit">'.$submit.'</button></form>';
	}	
//==============================================================================
    protected function showTextArea(string $fieldname, array $fieldinfo, string $current_value)
    {
        return '<textarea name="'.$fieldname.'" 
        		placeholder="'.$fieldinfo['placeholder'].'">'.$current_value.'</textarea>';    
    }
//==============================================================================
    protected function showSelect($fieldname, $fieldinfo, $current_value)
    {        
        $ret = '      <select name="'.$fieldname.'">'.PHP_EOL;
        $options = $this->getValueFromArray('options',$fieldinfo,[]);
        if ($options)
        {
            foreach ($options as $key => $value)
            {
                $selected = $current_value==$value ? "selected" : "";
                $ret .= '<option value="'.$value.'" '.$selected.'>'.$key.'</option>'.PHP_EOL;
            }    
        }
        $ret .= '      </select>'.PHP_EOL;
        return $ret;
    }
//==============================================================================
    protected function showSelectMultiple($fieldname, $fieldinfo, $current_value)
    {        
        $ret = '      <select name="'.$fieldname.' "multiple>'.PHP_EOL;
        $options = $this->getValueFromArray('options',$fieldinfo,[]);
        if ($options)
        {
            foreach ($options as $key => $value)
            {
                $selected = $current_value==$value ? "selected" : "";
                $ret .= '<option value="'.$value.'" '.$selected.'>'.$key.'</option>'.PHP_EOL;
            }    
        }
        $ret .= '      </select>'.PHP_EOL;
        return $ret;
    }
//==============================================================================
    protected function showInputField(string $fieldname, array $fieldinfo, string $current_value)
    {
        return ' <input type="'.$fieldinfo['type'].'"name="'.$fieldname.'"'. 
             ' placeholder="'.$fieldinfo['placeholder'].'"value="'.$current_value.'"/>';
    }        
//==============================================================================
	protected function getPostResultFor(string $key) : string
	{
		return (isset($this->postresult[$key]) ?  $this->postresult[$key] : '');
	}

//==============================================================================
    protected function getValueFromArray(string $key, array $arr, mixed $default='') : mixed
    {
        return (isset($arr[$key])
                ? $arr[$key]
                : $default);
    } 
//==============================================================================
}