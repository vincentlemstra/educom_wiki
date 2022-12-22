<?php
//=============================================================================
// FILE : form_element.php - form-element extending the base element :
//=============================================================================
require_once 'baselist.class.php';
class FormElement extends BaseList
{
	protected array $forminfo;
	protected array $postresult;

	public function __construct(array $forminfo, ?array $postresult=[])
	{
        $this->forminfo 	= $forminfo;
		$this->postresult 	= $postresult;
        parent::__construct($this->forminfo);
	}
//==============================================================================	
	public function openList()
	{
		$page = $this->getValueFromArray('page', $this->forminfo, 'NOTSET');
        $action = $this->getValueFromArray('action', $this->forminfo, '');
        $method = $this->getValueFromArray('method', $this->forminfo, 'POST');
        echo '<form action="'.$action.'" method="'.$method.'" enctype="multipart/form-data" >
              <input type="hidden" name="page" value="'.$page.'" />';
	}
//==============================================================================
	public function showItems()
	{
		foreach ($this->forminfo as $name => $info)
        {
            $current_value = $this->getFieldValue($name, $info);
            echo '<label for="'.$name.'">'.$info['label'].'</label><br />';

            switch ($info['type'])
            {
                case "textarea" :
                    $this->showTextArea($name, $info,$current_value);
                    break;
                case "select" :
                    $this->showSelect($name, $info,$current_value);
                    break;
                case "select multiple" :
                    $this->showSelectmultiple($name, $info,$current_value);
                    break;
                case "submit" :
                    $this->showSubmit($name, $info);
                    break;
                default :   
                    $this->showInputField($name, $info, $current_value);
                    break;
            }
            echo '<br />'.PHP_EOL;
            if (isset($this->postresult[$name.'_err']))
            {
                    echo '<span class="error">* '.$this->postresult[$name.'_err'].'</span><br/>';
            }           
        }
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
        echo '  <button type="submit" value="submit">'.$submit.'</button></form>';
	}	
//==============================================================================
    protected function showTextArea(string $fieldname, array $fieldinfo, string $current_value)
    {
        echo '	<textarea name="'.$fieldname.'" 
        		placeholder="'.$fieldinfo['placeholder'].'">'.$current_value.'</textarea>';    
    }
//==============================================================================
    protected function showSelect($fieldname, $fieldinfo, $current_value)
    {        
        echo '      <select name="'.$fieldname.'">'.PHP_EOL;
        $options = $this->getValueFromArray('options',$fieldinfo,[]);
        if ($options)
        {
            foreach ($options as $key => $value)
            {
                $selected = $current_value==$value ? "selected" : "";
                echo '<option value="'.$value.'" '.$selected.'>'.$key.'</option>'.PHP_EOL;
            }    
        }
        echo '      </select>'.PHP_EOL;
    }
//==============================================================================
    protected function showSelectMultiple($fieldname, $fieldinfo, $current_value)
    {        
        echo '      <select name="'.$fieldname.' "multiple>'.PHP_EOL;
        $options = $this->getValueFromArray('options',$fieldinfo,[]);
        if ($options)
        {
            foreach ($options as $key => $value)
            {
                $selected = $current_value==$value ? "selected" : "";
                echo '<option value="'.$value.'" '.$selected.'>'.$key.'</option>'.PHP_EOL;
            }    
        }
        echo '      </select>'.PHP_EOL;
    }
//==============================================================================
    protected function showSubmit(string $fieldname, array $fieldinfo)
    {
        echo ' <button type="'.$fieldinfo['type'].'"name="'.$fieldname.
                '"value="">'.$fieldinfo['value'].'</button>';
    }   
//==============================================================================
    protected function showInputField(string $fieldname, array $fieldinfo, string $current_value)
    {
        echo ' <input type="'.$fieldinfo['type'].'"name="'.$fieldname.'"'. 
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