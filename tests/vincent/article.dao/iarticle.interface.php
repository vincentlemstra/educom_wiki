<?php
interface iArticleModel 
{
    public function getArticleById(int $id) : array;
    public function getArticleByIdForEdit(int $id) : array;
    public function getArticlesBySearch(array $tag_id, array $author_id) : array;
    public function getArticleNamesByAuthorId(int $id) : array; 
    public function setArticleTags(int $article_id, array $tags) : int;
    
    public function createTag(string $tagname) : int;
    public function getAllTags() : array;
    public function getTagsByArticleId() : array;
    
    public function rateArticleById(int $article_id, int $author_id, int $rating) : float;

    public function createArticle(int $author_id, string $title, string $img, string $explanation, string $code_block, array $tags) : int; 
    public function updateArticleById(int $id, string $title, string $img, string $explanation, string $code_block, array $tags) : int;
    public function deleteArticleById(int $id) : int; 
}