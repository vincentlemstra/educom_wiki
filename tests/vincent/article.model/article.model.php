<?php
require_once "iarticle.interface.php";
require_once "base.model.php";

class ArticleModel extends BaseModel implements iArticleModel
{
    // ==============================================================================================
    // getArticleById
    // out: article.id -.author_id -.title -.img -.explanation -.code_block -.date_edit -.date_create
    // ==============================================================================================
    public function getArticleById(int $article_id) : array 
    {
        $sql = "SELECT * FROM article WHERE id = ?";
        $var = [$article_id];
        return $this->crud->read($sql, $var);
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
    public function getTagsByArticleId(int $article_id) : array 
    {
        $sql = 
        "SELECT tagname FROM tag 
        JOIN article_tag ON article_tag.tag_id = tag.id        
        WHERE article_id = ?"; 
        $var = [$article_id];
        return $this->crud->read($sql, $var);
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
    // createArticle
    // out: lastInsertId()
    // ==============================================================================================
    public function createArticle(
        int $author_id, 
        string $title, 
        string $img, 
        string $explanation, 
        string $code_block, 
        string $date_create, 
        array $tags
            ) : int
    {
        $sql = "INSERT INTO article (author_id, title, img, explanation, code_block, date_create) VALUES (?, ?, ?, ?, ?, ?)";
        $var = [$author_id, $title, $img, $explanation, $code_block, $date_create];
        $article_id = $this->crud->create($sql, $var);

        $this->setArticleTags($article_id, $tags);

        return $article_id;
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
}

