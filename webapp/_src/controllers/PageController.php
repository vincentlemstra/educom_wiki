<?php
require_once 'MainController.php';
require_once SRC.'models/basemodel.php';
require_once SRC.'models/authormodel.php';
require_once SRC.'models/articlemodel.php';
class PageController extends MainController implements iController
{
    protected array $request;
    protected array $response;
    protected array $elements;
    protected ?BaseModel $basemodel = null;
    protected ?AuthorModel $authormodel = null;
    protected ?ArticleModel $articlemodel = null;
    protected ?iHtmlDoc $doc = null;

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
            // add log ? 
            // add custom error message?
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
        $this->response = $this->request;// getoond == gevraagd
        $this->elements = []; 
        if ($this->isPageAllowed())
        {    
            $this->request['posted']
            ? $this->handlePostRequest()
            : $this->handleGetRequest();
        }
        else
        {
            $this->doc = $this->getBasemodel()->createWikiDoc($this->response);
            require_once SRC.'views/text_block_view_element.php';
            require_once SRC.'views/footer_element.php';
            $this->doc->addBodyElement(20, new TextBlockViewElement($this->getBasemodel()->sitedao->getTextByPage($this->response['page']),'div class="wrapper"'));
            $this->doc->addBodyElement(20, new FooterElement('&copy; '.date("Y").'&nbsp;', 'footer'));
        }
    }
//==============================================================================
    protected function showResponse()
    {
        //create new html doc --> standard elements (Html document, header, title, menu and message)
        $this->doc = $this->getBasemodel()->createWikiDoc($this->response);
         //variable elements:
         
        foreach($this->elements as $element)
        {
            //for each elements add elements to htmlDoc
           $this->doc->addBodyElement($element);
        }

        //add standard elements to html document -> footer, JS, CSS
        if ($this->doc)
        {
            //standard elements
            require_once SRC.'views/footer_element.php';
            $this->doc->addBodyElement(new FooterElement(100, '&copy; '.date("Y").'&nbsp;', 'footer'));
            //CSS
            require_once SRC.'views/element.php';
            $this->doc->addHeadElement(new Element(0,'<link rel="stylesheet" href="./assets/css/style.css"/>'));
            //JavaScript
            //$this->doc->addJsFile('./assets/js/rate.js', false);
            $this->doc->show();
        }  
// anders Errorpage?        
    }
//==============================================================================
    protected function isPageAllowed() : bool
    {
        //echo Basemodel::loggedauthor();
        if (BaseModel::loggedAuthor())
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
            if (in_array($this->response['page'], ['logout','edit','newarticle']))
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
        if ($this->getBaseModel()->validatePostedForm($this->response))
        {
            switch ($this->response['page'])
            {
                case 'contact': 
                    $this->elements [] = $this->getAuthorModel()->handleContact($this->response);
                    break;
                case 'login':
                    require_once SRC.'views/form_element.php';
                    $this->elements [] = $this->getAuthorModel()->handleLogin($this->response);
                    break;
                case 'register':
                    //not finished -> to Do .. 
                    $this->elements [] = $this->getAuthorModel()->handleRegistration($this->response);
                    break;
                case 'newarticle':
                    $this->elements [] = $this->getArticleModel()->handleNewArticle($this->response);
                    break;
                case 'editarticle':
                    $this->elements [] = $this->getArticleModel()->handleEditArticle($this->response);
                    break;  
                case 'Author':
                    $this->elements [] = $this->getAuthorModel()->handleAuthorItems($this->response);
                    break;
            }
        }  
        else
        {
            require_once SRC.'views/form_element.php';
            $this->elements [] = new FormElement(20, $this->response,$this->response['fieldinfo'], $this->response['postresult']);
        }
    }
//==============================================================================
    protected function handleGetRequest()
    {
        switch ($this->response['page'])
        {
            case 'home':
                require_once SRC.'views/text_block_view_element.php';
                $this->elements [] = new TextBlockViewElement(20, $this->getBasemodel()->sitedao->getTextByPage($this->response['page']),'div class="wrapper"');
                break;
            case 'about':
                require_once SRC.'views/text_block_view_element.php';
                require_once SRC.'views/authorlist_view_element.php';
                $this->elements [] = new TextBlockViewElement(20, $this->getBasemodel()->sitedao->getTextByPage($this->response['page']),'div class="wrapper"');
                $this->elements [] = new AuthorListView(20, $this->getAuthorModel()->getAllAuthors());
                break;
            case 'contact':
            case 'login':
            case 'register':
            case 'search':
            case 'newarticle':
                //To do : create 1 line, let de model start the createwikiformdoc if checks are ok.. else add other elements (tekstblock and error message)
                $this->response = $this->getBaseModel()->createWikiFormDoc($this->response);
                require_once SRC.'views/form_element.php';
                $this->elements [] = new FormElement(20, $this->response['forminfo'],$this->response['fieldinfo']);
                break;
            case 'article':
                $this->elements [] = $this->getArticleModel()->handleArticleDetail($this->response);
                break;
            case 'editarticle':
                require_once SRC.'views/form_element.php';
                $this->elements [] = $this->getArticleModel()->handleArticleDetailForm($this->response);
                break;
            case 'author':
                require_once SRC.'views/article_view_element.php';
                $this->elements [] = $this->getAuthorModel()->handleAuthorDetail($this->response);
                $this->elements [] = $this->getAuthorModel()->handleAuthorArticles($this->response);
                break; 
            case 'logout':
                $this->elements [] = $this->getAuthorModel()->handleLogout($this->response);
                break;
        }
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
    protected function getArticleModel() : ArticleModel
    {
        if (is_null($this->articlemodel))
        {
            $this->articlemodel = new ArticleModel();
        }
        return $this->articlemodel;    
    }     
//============================================================================== 
}	

