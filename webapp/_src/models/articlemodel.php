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
            $this->doc = new ShowMessage($response);
            return $this->doc;
        }
        else
        { 
            $article['tag'] = $this->getTagsByArticleId($id);
            $count_tags = count($article['tag']);
            $tags = '';
            for($x = 0 ; $x < $count_tags; $x++)
            { 
                $tags .= $article['tag'][$x]['name'].' ';
            }
            $article['id'] =$id;
            $article['tag'] = $tags;
            //to get rating from Database
            $article['rating'] = 5;
            $response['article'] = $article;
            require_once SRC.'views/article_view_element.php';
            $this->doc = new ArticleView($article , 'div class="article-grid"');
            return $this->doc;
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
        Tools::dump($response['postresult']);
        $response[SYSMSG] = 'Article succesfully saved';
        $this->doc = $this->createWikiDoc($response);
        require_once SRC.'views/text_block_view_element.php';
        require_once SRC.'views/article_view_element.php';
        $article = $this->getArticleById($id);
        $article['tags'] = $this->getTagsByArticleId($id);
        $article['rating'] = 'n/a'; // TO DO RATING !!
        $this->doc->addElement(new ArticleView($article, 'div class="article-grid"'));
        
        //OK-> Save and Show article and give succes message.
        return $this->doc;
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
            $article = $this->getArticleById($id);
        }
        if($article === false)
        {
            $response[SYSERR] = 'Blog niet gevonden';
            $response['page'] = 'search';
            //error message toevoegen --> issue met volgorde elementen .. 
            require_once SRC.'views/msg_view_element.php';
            $this->doc = new ShowMessage($response);
            return $this->doc;
        }
        elseif($article['author_id'] == $_SESSION['UID'])
        { 
            $article['tag'] = $this->getTagsByArticleId($id);
            $count_tags = count($article['tag']);
            $tags = '';
            for($x = 0 ; $x < $count_tags; $x++)
            { 
                $tags .= $article['tag'][$x]['name'].' ';
            }
            $article['id'] =$id;
            $article['tag'] = $tags;
            
            $response = $this->createWikiFormDoc($response);

            require_once SRC.'views/text_block_view_element.php';
            require_once SRC.'views/article_view_element.php';
            $article = $this->getArticleById($id);
            $article['tags'] = $this->getTagsByArticleId($id);
            $article['rating'] = 'n/a'; // TO DO RATING !!
            //$this->doc->addElement(new ArticleView($article, 'div class="article-grid"'));
            $response['postresult'] = $article;
            //OK-> Save and Show article and give succes message.
            return $response;
        // if so get article data and tags
         // create wikiformdocforarticle
        }
        else 
        {
            // go to home? 
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
    // out: lastInsertId()
    // ==============================================================================================
    public function updateArticleById(
        int $article_id, 
        string $title, 
        string $img, 
        string $explanation, 
        string $code_block, 
        array $tags
            ) : int
    {
        $sql = "UPDATE article SET title = ?, img = ?, explanation = ?, code_block = ?, date_edit =  CURRENT_TIMESTAMP() WHERE id = ?";
        $var = [$title, $img, $explanation, $code_block, $article_id];
        $article_id = $this->crud->update($sql, $var);

        $this->deleteArticleTags($article_id);
        $this->setArticleTags($article_id, $tags);

        return $article_id;
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
