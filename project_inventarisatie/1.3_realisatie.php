<?php
# 1.3: Models

interface iAuthorModel
{
    public function getAllAuthors() : array | false
    public function getAllAuthorNames() : array | false
    public function getAuthorById(int $id) : array | false
    public function getAuthorByEmail(string $email) : array | false
    public function createAuthor(array $author) : int | false
}

interface iArticleModel 
{
    public function createTag(string $tagname) : int | false
    public function getAllTags() : array | false
    public function getArticlesBySearch(array $tag_id, array $auteur_id) : array | false
    public function getArticleById(int $id) : array | false
    public function getArticleByIdForEdit(int $id) : array | false
    public function rateArticleById(int $article_id, int $author_id, int $rating) : float | false
    public function createArticle(array $article, array $tags) : int | false // geen array: maar per veld invoegen. bv: string $titel, string $uitleg, etc...
    public function deleteArticleById(int $id) : int | false 
    public function updateArticleById(array $article) : int | false 
    public function getArticleNamesByAuthorId(int $id) : array | false
}
