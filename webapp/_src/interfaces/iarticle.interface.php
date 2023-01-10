<?php
interface iArticleModel 
{
    public function getArticleById(int $id) : array;
    public function getArticleByIdForEdit(int $id) : array;
    public function getArticlesBySearch(array $author_id, array $tag_id) : array;
    public function getArticleNamesByAuthorId(int $id) : array; 
    public function createTag(string $tagname) : int;
    public function getAllTags() : array;
    public function getTagsByArticleId(int $id) : array;
    public function rateArticleById(int $article_id, int $author_id, int $rating) : int;
    public function createArticle(int $author_id, string $title, string $img, string $explanation, string $code_block, string $date_create, array $tags) : int;
    public function updateArticleById(int $article_id, string $title, string $img, string $explanation, string $code_block, array $tags) : int;
    public function deleteArticleById(int $id) : int; 
}