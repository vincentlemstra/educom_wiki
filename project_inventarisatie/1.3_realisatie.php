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
        // WF: 2.0, 2.1, 6.0 || input: - || output: author firstname, author preposition, author lastname (concatenated), author id
        //=======================================
        
    public function getAuthorById(int $id) : array | false
        //=======================================
        // WF: 1.0 || input: author id || output: author firstname
        // WF: 9.0, 9.1 || input: author id || output: author firstname, author preposition, author lastname, author description
        // WF: 10.0 || input: author id || output: author firstname, author preposition, author lastname
        // WF: 11.0, 11.1 || input: author id || output: author firstname, author preposition, author lastname
        // WF: 14.0 || input: author id || output: author firstname, author preposition, author lastname, author birthdate, author email, 
        //      author telephonenumber, author description, author picture
        //=======================================
        
    public function getAuthorByEmail(string $email) : array | false
        //=======================================
        // used in WF: ???
        // input: author email
        // output: ???
        //=======================================
        
    public function createAuthor(array $author) : int | false
        //=======================================
        // used in WF: 5.0 || input: author firstname, lastname, email, date of birth, password, password_repeat 
        // action: validate author firstname, lastname, email, password, passwod_repeat
        //          save validated user details in separate table to be approved for access by admin
        // output: id of last saved record
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
