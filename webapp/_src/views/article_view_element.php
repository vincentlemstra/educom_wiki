<?php
require_once 'i_Html_Element.php';
class ArticleView implements iView
{
   protected array $article;
   
    public function __construct(array $article, string $wrapper)
    {
       $this->article= $article;
       $this->wrapper= $wrapper;
    }

    public function show() : void
    {
        echo 
         '<'.$this->wrapper.'>'.PHP_EOL
        .'<div class="article_image">'.$this->article['image'].'</div>'.PHP_EOL
        .'<div class="article_title">'.$this->article['title'].'</div>'.PHP_EOL
        .'<div class="article_tag">'.$this->article['tag'].'</div>'.PHP_EOL
        .'<div class="article_date">'.$this->article['date_modified'].'</div>'.PHP_EOL
        .'<div class="article_author">'.$this->article['author'].'</div>'.PHP_EOL
        .'<div class="article_rate">'.$this->article['beoordeling'].'</div>'.PHP_EOL
        .'<div class="article_text">'.$this->article['uitleg'].'</div>'.PHP_EOL
        .'<div class="article_code">'.$this->article['codeblock'].'</div>'.PHP_EOL
        .'</'.$this->wrapper.'>'.PHP_EOL
        ;
    }
}