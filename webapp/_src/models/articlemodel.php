<?php
require_once SRC."interfaces/iarticle.interface.php";
require_once "basemodel.php";

class ArticleModel extends BaseModel implements iArticleModel
{
    // ==============================================================================================
    // getArticleById
    // out: article.id -.author_id -.title -.img -.explanation -.code_block -.date_edit -.date_create
    // ==============================================================================================
       public function getArticleById(int $id) : array|false
    {
        return $this->_crud->selectOne("SELECT * FROM article WHERE id =:id",
                                        ['id' => [$id, true]]);
    }
    // ================================================================== 
    public function handleArticleDetail(&$response) 
    {
        $id = Tools::getRequestVar('article_id', false, 0, true);
        Tools::dump($response);
        if($id === 0)
        {
            $response[SYSERR] = 'Ongeldige Blog';
            $article = false;
        }
        else 
        {
            $article = $this->getArticleById($id);
        }
        if($article === false)
        {
            $response[SYSERR] = 'Blog niet gevonden';
            $response['page'] = 'search';
            //error message toevoegen --> issue met volgorde elementen .. 
            require_once SRC.'views/msg_view_element.php';
            $element = new ShowMessage($response);
            return $element;
        }
        else
        { 
            $article['tags'] = $this->getTagsByArticleId($id);
            $count_tags = count($article['tags']);
            $tags = '';
            for($x = 0 ; $x < $count_tags; $x++)
            { 
                $tags .= $article['tags'][$x]['name'].' ';
            }
            $article['id'] = $id;
            $article['tags'] = $tags;
            //to get rating from Database
            $article['rating'] = 5;
            $response['article'] = $article;
            require_once SRC.'views/article_view_element.php';
            $element = new ArticleView($article, $this->loggedAuthor(), 'div class="article-grid"');
            return $element;
        }
    }
    //==================================================================
    public function handleNewArticle(&$response)
    {
        //Tools::dump($response['postresult']);
        //to do -> check if article title exists? 
        $article = array();
        $article['author_id'] = $_SESSION['UID'];
        $article['title'] = $response['postresult']['title'];
        $article['tags'] = $response['postresult']['tag'];
        $article['explanation'] = $response['postresult']['explanation'];
        $article['img'] = $response['postresult']['img'] = null; // to do
        $article['code_block'] = $response['postresult']['code_block'];
        $article['date_create'] = $response['postresult']['date_create'] = null; // to do

        //insert new article
        $id = $this->createArticle($article['author_id'],$article['title'],$article['img'],$article['explanation'],
                                $article['code_block'], $article['date_create'], $article['tags']);

        if( $id === false )
        {
            //if error show message --> TO DO !!!!
            $response[SYSMSG] = 'Article could not be saved.. ';
        }
        else
        {
            $response['page']= 'article';
            $response[SYSMSG] = 'Article succesfully saved';
            require_once SRC.'views/text_block_view_element.php';
            require_once SRC.'views/article_view_element.php';
            $article = $this->getArticleById($id);
            $article['tags'] = $this->getTagsByArticleId($id);
            $article['rating'] = 'n/a'; // TO DO RATING !!
            $element = new ArticleView($article, $this->loggedAuthor(), 'div class="article-grid"');
            
            //OK-> Save and Show article and give succes message.
            return $element;
        }
    }

//TO DOO handleArticleDetailForm --> not finished ;)
    //==================================================================
    public function handleArticleDetailForm(&$response)
    {        
        // check if author id and blog id are matching
        $article['id'] = Tools::getRequestVar('article_id',false,0,true);
        if($article['id']=== 0)
        {
            $response[SYSERR] = 'Ongeldige Blog';
            $article = false;
        }
        else 
        {
            $article = $this->getArticleById($article['id']);
        }
        if($article === false)
        {
            $response[SYSERR] = 'Blog niet gevonden';
            $response['page'] = 'search';
            require_once SRC.'views/msg_view_element.php';
            $element = new ShowMessage($response);
        //add element search ? 
            return $element;
        }
        elseif($article['author_id'] == $_SESSION['UID'])
        { 
            $article['tags'] = $this->getTagsByArticleId($article['id']);
            $count_tags = count($article['tags']);
            $tags = '';
            for($x = 0 ; $x < $count_tags; $x++)
            { 
                $tags .= $article['tags'][$x]['name'].' ';
            }
            //$article['id'] =$id;
            $article['tags'] = $tags;
            $response = $this->createWikiFormDoc($response);

            require_once SRC.'views/text_block_view_element.php';
            require_once SRC.'views/article_view_element.php';
            $article = $this->getArticleById($article['id']);
            $article['tags'] = $this->getTagsByArticleId($article['id']);
            $article['rating'] = 'n/a'; // TO DO RATING !!
            $response['postresult'] = $article;
            $element = new FormElement($response['forminfo'],$response['fieldinfo'], $response['postresult']);
            return $element;
        }
        else 
        {
            // add error message and go to homepage
            $response[SYSERR] = 'Sorry, je mag dit blog niet aanpassen. Je kan alleen je eigen blogs aanpassen.';
            require_once SRC.'views/msg_view_element.php';
            $element = new ShowMessage($response);
            return $element;         
        }
       
    }
    // ==================================================
    public function handleEditArticle(&$response)
    {
        //check if article nr is matching with authors created articles in db
         $article['id'] = Tools::getRequestVar('article_id',false,0,true);
         if($article['id']=== 0)
         {
             $response[SYSERR] = 'Ongeldige Blog';
             $article = false;
         }
         else 
         {
             $article = $this->getArticleById($article['id']);
         }
         if($article === false)
         {
             $response[SYSERR] = 'Blog niet gevonden';
             $response['page'] = 'search';
             require_once SRC.'views/msg_view_element.php';
             $elements [] = new ShowMessage($response);
         //add element search ? 
             return $elements;
         }
         elseif($article['author_id'] !== $_SESSION['UID'])
         { 
        //if not, reply error, article cannot be edited..
            $response[SYSERR] = 'Blog niet gevonden';
            $response['page'] = 'search';
            require_once SRC.'views/msg_view_element.php';
            $elements [] = new ShowMessage($response);
            return $elements;
       
        }
        else
        {
        //if ok, save the article -->update query of current article ID. 
            $response['postresult']['img'] = null;
            $id = $this->updateArticleById($article['id'], $response['postresult']['title'], $response['postresult']['img'], 
                                            $response['postresult']['explanation'], $response['postresult']['code_block'], 
                                            $response['postresult']['tag']);
        }
        //if succes -> show article with succes message
        if($id)
        {
            $response['page']= 'article';
            $response[SYSMSG] = 'Article succesfully saved';
            require_once SRC.'views/article_view_element.php';
            $article = $this->getArticleById($article['id']);
            $article['tags'] = $this->getTagsByArticleId($article['id']);
            $article['rating'] = 'n/a'; // TO DO RATING !!
            $element = new ArticleView($article, $this->loggedauthor(), 'div class="article-grid"');
            
            //OK-> Save and Show article and give succes message.
            return $element;
        }
        //no succes -> add error msg and show author page.
        else
        {
            $response[SYSERR] = 'Article not saved, error occurred during saving..did you adjust anything at all?';
            $response['page'] = 'home';
            require_once SRC.'views/text_block_view_element.php';
            $element = new TextBlockViewElement($this->sitedao->getTextByPage($response['page']),'div class="wrapper"');
            return $element;

        }
    }
    // ==============================================================================================
    // createArticle
    // out: lastInsertId()
    // ==============================================================================================
    public function createArticle(int $author_id, string $title, /*string*/ $img, string $explanation, /*string*/ $code_block, 
                                    /*string*/ $date_create, array|string $tags) : int|false // TO do check data types .. AND Creation date is automically added in MYSQL
    {
        return $this->_crud->doInsert( 
            "INSERT INTO article (author_id, title, img, explanation, code_block, date_create) VALUES (:author_id, :title, :img, :explanation, :code_block, :date_create)",
                [
                    'author_id'      => [$author_id, true], 
                    'title'     => [$title, false], 
                    'img'  => [$img, false],
                    'explanation'  => [$explanation, false],
                    'code_block'  => [$code_block, false],
                    'date_create'  => [$date_create, false],
                ]
                );
     // TO do create new article tags :-)    
    }
       
    // ==============================================================================================
    // getArticleByIdForEdit
    // out: article.id -.author_id -.title -.img -.explanation -.code_block -.date_edit -.date_create
    // ==============================================================================================
    public function getArticleByIdForEdit(int $id) : array
    {
        // todo - still needed?
    }

    // ==============================================================================================
    // getArticlesBySearch
    // out: article.id -.title
    // ==============================================================================================
    public function getArticlesBySearch(array $author_id, array $tag_id) : array
    {
        $author_ids= implode(',',array_values($author_id));
        $tags_ids= implode(',', array_values($tag_id));

        $sql = 
        "SELECT DISTINCT article.id, article.title FROM article
        LEFT JOIN author on article.author_id = author.id
        LEFT JOIN article_tag ON article.id = article_tag.article_id
        LEFT JOIN tag ON article_tag.tag_id = tag.id
        WHERE article.author_id IN (?) OR tag_id IN (?)";
        $var = [$author_ids, $tags_ids];
        return $this->crud->read($sql, $var);
    } 

    // ==============================================================================================
    // getArticleNamesByAuthorId
    // out: article.title
    // ==============================================================================================
    public function getArticleNamesByAuthorId(int $author_id) : array
    {
        $sql = "SELECT title FROM article WHERE author_id = ?";
        $var = [$author_id];
        return $this->crud->read($sql, $var);
    } 

    // ==============================================================================================
    // getArticleNamesByAuthorId
    // out: lastInsertId()
    // ==============================================================================================
    public function createTag(string $tagname) : int
    {
        $sql = "INSERT INTO tag (tagname) VALUES (?)";
        $var = [$tagname];
        return $this->crud->create($sql, $var);
    }

    // ==============================================================================================
    // getAllTags
    // in : -
    // out: tag.id, tag.tagname
    // ==============================================================================================
    public function getAllTags() : array
    {
        $sql = "SELECT * FROM tag";
        return $this->crud->readAll($sql);
    }

    // ==============================================================================================
    // getTagsByArticleId
    // out: tag.tagname
    // ==============================================================================================
    public function getTagsByArticleId(int $article_id) : array|false
    {
        return $this->_crud->selectMore("SELECT name FROM `article` JOIN article_tag ON article_tag.article_id = article.id 
                                        JOIN tag ON article_tag.tag_id = tag.id 
                                        WHERE article_id =:article_id", 
                                            [
                                                'article_id' => [$article_id, true]
                                            ]);      
    }

    // ==============================================================================================
    // rateArticleById
    // out: lastInsertId()
    // ==============================================================================================
    public function rateArticleById(int $article_id, int $author_id, int $rating) : int
    {
        $sql = "INSERT INTO rating (user_id, product_id, rating) VALUES (?, ?, ?)";
        $var = [$author_id, $article_id, $rating];
        return $this->crud->create($sql, $var);
    }

    // ==============================================================================================
    // updateArticleById
    // out: numberofrecords()
    // ==============================================================================================
    public function updateArticleById(int $article_id, string $title, /*string*/ $img, string $explanation, string $code_block, /*array*/ $tags) : int|false
    {
        return $this->_crud->doUpdate("UPDATE article SET title=:title, img=:img, explanation=:explanation, code_block=:code_block WHERE id=:id",
                                        [
                                            'title' => [$title, false],
                                            'img' => [$img, false],
                                            'explanation' =>[$explanation, false],
                                            'code_block' =>[$code_block, false],
                                            'id' => [$article_id, true]
                                        ]
                                    );
        //to do adjust article tags
    }

    // ==============================================================================================
    // deleteArticleById
    // out: lastInsertId()
    // ==============================================================================================
    public function deleteArticleById(int $id) : int
    {
        $sql = "DELETE FROM article WHERE id=?";
        $var = [$id];
        return $this->crud->delete($sql, $var);
    }

    // ==============================================================================================
    // setArticleTags
    // out: -
    // ==============================================================================================
    private function setArticleTags(int $article_id, array $tags) : array 
    {
        $affected_rows = [];
        for ($i = 0; $i<count($tags); $i++){
            $sql = "INSERT INTO article_tag (article_id, tag_id) VALUES (?, ?)";
            $var = [$article_id, $tags[$i]];
            $affected_rows[] = $this->crud->create($sql, $var);
        }
        return $affected_rows;
        // ! table article_tag does not have a ID column -> return value = 0
    }

    // ==============================================================================================
    // deleteArticleTags
    // out: lastInsertId()
    // ==============================================================================================
    private function deleteArticleTags(int $article_id) : int
    {
        $sql = "DELETE FROM article_tag WHERE article_id=?";
        $var = [$article_id];
        return $this->crud->delete($sql, $var);
    }
    // ==============================================================================================

}
