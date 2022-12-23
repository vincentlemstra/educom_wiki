<?php
require_once "iarticle.interface.php";
require_once "base.model.php";

class ArticleModel extends BaseModel // implements iArticleModel
{
    public function getArticleById(int $id) : array 
    {
        $sql = "SELECT * FROM article WHERE id = ?";
        $var = [$id];
        return $this->crud->read($sql, $var);
    }

    // todo : wat was het verschil bij ForEdit?
    public function getArticleByIdForEdit(int $id) : array
    {
        $sql = "SELECT * FROM article WHERE id = ?";
        $var = [$id];
        return $this->crud->read($sql, $var);
    }

    public function getArticlesBySearch(array $tag_id, array $auteur_id) : array
    {
        
    }
}

