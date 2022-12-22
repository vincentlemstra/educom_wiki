<?php
require_once "iarticle.interface.php";
class ArticleModel // implements iArticleModel
{
    public function getArticleById(int $id) : array 
    {
        // dummy data
        if ($id == 0) {
            return false;
        } 

        return [
            'author_id'     =>  '1',
            'title'         =>  'PHP for Loop',
            'img'           =>  'PATH TO IMAGE',
            'explanation'   =>  'The for loop - Loops through a block of code a specified number of times.',
            'code_block'    =>  'CODE BLOCK',          
        ];
    }
}