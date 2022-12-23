<?php
require_once "iarticle.interface.php";
require_once "base.dao.php";

class ArticleDAO extends BaseDAO // implements iArticleDAO
{
    public function getArticleById(int $id) : array 
    {
        $sql = "SELECT * FROM article WHERE id = ?";
        $var = [$id];
        return $this->crud->read($sql, $var);
    }

    public function getArticleByIdForEdit(int $id) : array
    {
        // todo       
    }

    public function getArticlesBySearch(array $author_id, array $tag_id)
    {
        // todo duplicates wegwerken (tags los koppelen?)
        $author_ids= implode(',',array_values($author_id));
        $tags_ids= implode(',', array_values($tag_id));

        $sql = 
        "SELECT title FROM article
        LEFT JOIN author on article.author_id = author.id
        LEFT JOIN article_tag ON article.id = article_tag.article_id
        LEFT JOIN tag ON article_tag.tag_id = tag.id
        WHERE article.author_id IN (?) OR tag_id IN (?)";
        $var = [$author_ids, $tags_ids];
        return $this->crud->read($sql, $var);
    } 

    public function getArticleNamesByAuthorId(int $id) : array
    {
        $sql = "SELECT * FROM article WHERE author_id = ?";
        $var = [$id];
        return $this->crud->read($sql, $var);
    } 

    public function createTag(string $tagname) : int
    {
        $sql = "INSERT INTO tag (tagname) VALUES (?)";
        $var = [$tagname];
        return $this->crud->create($sql, $var);
    }

    public function getAllTags() : array
    {
        $sql = "SELECT * FROM tag";
        return $this->crud->readAll($sql);
    }

    public function getTagsByArticleId(int $id) : array 
    {
        $sql = 
        "SELECT tagname FROM tag 
        JOIN article_tag ON article_tag.tag_id = tag.id        
        WHERE article_id = ?"; 
        $var = [$id];
        return $this->crud->read($sql, $var);
    }

    public function rateArticleById(int $article_id, int $author_id, int $rating) : float
    {
        // todo
    }

    public function createArticle(int $author_id, string $title, mixed $img, string $explanation, string $code_block, string $date_create, array $tags) : int
    {
        $sql = "INSERT INTO article (author_id, title, img, explanation, code_block, date_create) VALUES (?, ?, ?, ?, ?, ?)";
        $var = [$author_id, $title, $img, $explanation, $code_block, $date_create];
        $article_id = $this->crud->create($sql, $var);
        setArticleTags($article_id, $tags);
    }

    public function setArticleTags(int $article_id, array $tags) : int
    {
        $sql = "INSERT INTO article_tag (article_id, tag_id) VALUES (?, ?)";
        $var = [$article_id, $tags];

        // todo loop thru each tag and run the query so that it creates multiple entries
    }


      
}

