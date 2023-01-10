<?php
require_once SRC.'dal/siteDAO.php';
class BaseModel {
    // --- PROPERTIES ---
    //protected SiteDAO $sitedao; //crud in future, when sitedao is in database !! :-)

    // --- CONSTRUCT ---
    public function __construct()
    {
        $this->sitedao = new siteDAO(); //Crud in future !! 
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
        require_once SRC.'views/html_doc.php';
        $this->updateResponse($response);
        return new HtmlDoc($response);
    }    
    //==============================================================================
    public function createWikiFormDoc(&$response) : HtmlDoc
    {
        require_once SRC.'views/WebShopFormDoc.php';
        $this->updateResponse($response);
        $response['forminfo'] = $this->sitedao->getFormInfoByPage($response['page']);
        $response['fieldinfo'] = $this->sitedao->getFieldInfoByPage($response['page']);
        return new WebShopFormDoc($response);
    }    
    //==============================================================================
    protected function updateResponse(&$response)
    {
        $loggedauthor = $this->loggedAuthor();
        $response['loggedauthor'] = $loggedauthor;
        $response['menuitems'] = $this->sitedao->getMenuItems();
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
