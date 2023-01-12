<?php
require_once SRC.'dal/siteDAO.php';
class BaseModel {
    // --- PROPERTIES ---
    public SiteDAO $sitedao; //crud in future, when sitedao is in database !! :-)
    protected Crud $_crud;
    // --- CONSTRUCT ---
    public function __construct()
    {
        $this->sitedao = new siteDAO(); //Crud in future !! 
        //get intance of pdo/crud class
        $this->_crud = Crud::getInstance();
        //check if connection is made
        if ($this->_crud->isConnected()===false)
        {
            throw new Error("No database connection.");
        }			
       
    }
//==============================================================================
    public function getLastError() : string
    {
        return $this->_crud->getlastError();
    }    
//==============================================================================
public static function loggedAuthor() : bool
    {
        return Tools::getSesVar(USERID, 'NOP') !== 'NOP';
    }    
    //==============================================================================
    public function validatePostedForm(&$response) : bool
    {
        require_once SRC."tools/FormValidator.php";
        $validator = new FormValidator();
        $response['fieldinfo'] = $this->sitedao->getFieldInfoByPage($response['page']);
        $response['postresult'] = $validator->checkFields($response['fieldinfo']);
        return $response['postresult']['ok'];
    }    

    //==============================================================================
    public function createWikiDoc(&$response) : HtmlDoc
    {
        $this->updateResponse($response);
        require_once SRC.'views/html_doc.php';
        require_once SRC.'views/menu_element.php';
        require_once SRC.'views/msg_view_element.php';
        $this->doc = new HtmlDoc;
        $this->doc->setTitle('Wiki page');
        $this->doc->addElement(new MenuView($this->sitedao->getMenuItems($this->loggedAuthor()), $response['page']));
        $this->doc->addElement(new ShowMessage($response));
        return $this->doc;
    }    
    //==============================================================================
    
    public function createWikiFormDoc(&$response) : array
    {
        require_once SRC.'views/Form_Element.php';
        $this->updateResponse($response);
        $response['forminfo'] = $this->sitedao->getFormInfoByPage($response['page']);
        $response['fieldinfo'] = $this->sitedao->getFieldInfoByPage($response['page']);
        //$this->doc->addElement(new FormElement($response['forminfo'], $response['fieldinfo']));
        return $response;
    }    
    //==============================================================================
    protected function updateResponse(&$response)
    {
        $loggedauthor = $this->loggedAuthor();
        $response['loggedauthor'] = $loggedauthor;
        $response['menuitems'] = $this->sitedao->getMenuItems($loggedauthor);
        $response['bodytext'] = $this->sitedao->getTextByPage($response['page']);
    }
    //==============================================================================
    protected function addErrorMsg(&$response, string $e)
    {
        if ($response[SYSERR])
        {    
            $response[SYSERR] .= '<br/>'.$e;
        }    
        else
        {
            $response[SYSERR] = $e;
        }
        
    } 
}
