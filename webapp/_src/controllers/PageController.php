<?php
require_once 'MainController.php';
require_once SRC.'models/basemodel.php';
require_once SRC.'models/AuthorModel.php';
require_once SRC.'models/ArticleModel.php';
class PageController extends MainController implements iController
{
    protected array $request;
    protected array $response;
    protected ?BaseModel $basemodel = null;
    protected ?AuthorModel $AuthorModel = null;
    protected ?ArticleModel $ArticleModel = null;
    protected ?HtmlDoc $doc = null;

//==============================================================================
// Implementation of iController interface
//==============================================================================
    public function handleRequest()
    {
    try
        {
            ob_start(); 
            //throw new Exception('OOOOPS');
            $this->getRequest();
            $this->validateRequest();
            $this->showResponse();
            ob_end_flush();
        }
        catch(Exception $e) 
        {
            ob_end_clean();
            echo $e->getMessage(); 
        }
    }

//==============================================================================
    protected function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');
        $this->request = [
            'posted' => $posted,
            'page'   => Tools::getRequestVar('page', $posted, 'home')
        ];
    }
//==============================================================================
    protected function validateRequest()
    {
        $this->response = $this->request; // getoond == gevraagd
        if ($this->isPageAllowed())
        {    
            $this->request['posted']
            ? $this->handlePostRequest()
            : $this->handleGetRequest();
        }
        else
        {
            $this->doc = $this->getBaseModel()->createWebShopDoc($this->response);
        }
    }
//==============================================================================
    protected function showResponse()
    {
        if ($this->doc)
        {
            $this->doc->addCssFile('./assets/css/style.css');
            //$this->doc->addJsFile('./assets/js/jquery-3.6.1.min.js', true);
            //$this->doc->addJsFile('./assets/js/rate.js', false);
            $this->doc->show();
        }  
// anders Errorpage?        
    }
//==============================================================================
    protected function isPageAllowed() : bool
    {
        if (AuthorModel::loggedAuthor()) //to be made loggedAuthor check function
        {    
            if (in_array($this->response['page'], ['login','register']))
            {
                $this->response[SYSERR] = 'Eerst uitloggen a.u.b.';
                $this->response['page'] = 'home';
                $this->response['posted'] = 'false';
                return false;
            }
        }    
        else
        {
            if (in_array($this->response['page'], ['logout']))
            {
                $this->response[SYSERR] = 'Eerst inloggen a.u.b.';
                $this->response['page'] = 'login';
                $this->response['posted'] = 'false';
                return false;
            }
        }
        return true;
    }    
//==============================================================================    
    protected function handlePostRequest()
    {
       //via authormodel get access to validate function in basemodel, it is returning the values in response['postresult']
        if ($this->getAuthorModel()->validatePostedForm($this->response))
        {
            switch ($this->response['page'])
            {
                case 'contact': 
                    $this->doc = $this->authormodel->handleContact($this->response);
                    break;
                case 'login':
                    $this->doc = $this->authormodel->handleLogin($this->response);
                    break;
                case 'register':
                    $this->doc = $this->authormodel->handleRegistration($this->response);
                    break;
                case 'edit':
                //Tools::dump($this->response);
                    $this->doc = $this->getArticleModel()->handleEditItem($this->response);
                    break;
                case 'nieuw_item':
                    $this->doc = $this->getadminmodel()->HandleNewItem($this->response);
                    break;  
                case 'Author':
                    $this->doc = $this->getAuthorModel()->handleAuthorItems($this->response);
                    break;
            }
        }  
        else
        {
            $this->doc = $this->authormodel->createArticleFormDoc($this->response);
        }
    }        
//==============================================================================
    protected function handleGetRequest()
    {
        require_once SRC.'views/html_doc.php';
        require_once SRC.'views/menu_element.php';
        $this->doc = new HtmlDoc;
        $this->doc->setTitle('Wiki page');
        $this->doc->addElement(new MenuView($this->getBasemodel()->sitedao->getMenuItems()));

        switch ($this->response['page'])
        {
            case 'home':
            case 'about':
                require_once SRC.'views/text_block_view_element.php';
                $this->doc->addElement(new TextBlockViewElement($this->getBasemodel()->sitedao->getTextByPage($this->response['page']),'div class="wrapper"'));
                break;
            case 'contact':
            case 'login':
            case 'register':
            case 'search':
                require_once SRC.'views/form_element.php';
                $this->doc->addElement(new FormElement($this->getBaseModel()->sitedao->getFieldInfoByPage($this->response['page'])));
                break;
            case 'Article':    
                $this->doc = $this->getArticleModel()->handleArticleDetail($this->response);
                break;
            case 'EditArticle':
                $this->doc = $this->getArticleModel()->handleArticleEditFormDoc($this->response);
                break;
            case 'Author':
                $this->doc = $this->getAuthorModel()->creatAuthorDoc($this->response);
                break; 
            case 'logout':
                $this->doc = $this->getAuthorModel()->handleLogout($this->response);
                break;
        }
        require_once SRC.'views/footer_element.php';
        $this->doc->addElement(new FooterElement('&copy; '.date("Y").'&nbsp;', 'footer'));

    }    
//==============================================================================
//  CREATE WHEN NEEDED .... 
//==============================================================================
    protected function getBaseModel() : BaseModel
    {
        if (is_null($this->basemodel))
        {
            $this->basemodel = new BaseModel();
        }
        return $this->basemodel;    
    }    
//==============================================================================
    protected function getAuthorModel() : AuthorModel
    {
        if (is_null($this->authormodel))
        {
            $this->authormodel = new AuthorModel();
        }
        return $this->authormodel;    
    }    
//==============================================================================
    protected function getArticleModel() : WebshopModel
    {
        if (is_null($this->articlemodel))
        {
            $this->articlemodel = new ArticleModel();
        }
        return $this->articlemodel;    
    }     
//============================================================================== 
}	

