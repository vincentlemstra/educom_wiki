<?php
# 1.3: Models

interface iAuthorModel
{
    public function getAllAuthors() : array | false
        //=======================================
        // used in WF: ???
        // input: none
        // output: ???
        //=======================================
        
    public function getAllAuthorNames() : array | false
        //=======================================
        // used in WF: ???
        // input: none
        // output: all author names, concatenated to first + preposition + last, author id (to link to personal page/articles)?
        //=======================================
        
    public function getAuthorById(int $id) : array | false
        //=======================================
        // used in WF: ???
        // input: author id
        // output: ???
        //=======================================
        
    public function getAuthorByEmail(string $email) : array | false
        //=======================================
        // used in WF: ???
        // input: author email
        // output: ???
        //=======================================
        
    public function createAuthor(array $author) : int | false
        //=======================================
        // used in WF: ???
        // input: author firstname, lastname, email, date of birth, password, password_repeat
        // validate: author firstname, lastname, email, password, passwod_repeat
        // output: save validated user details in separate table to be approved for access by admin
        //=======================================
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
