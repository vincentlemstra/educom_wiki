<?php
require_once SRC.'interfaces/i_Html_Element.php';
class ArticleView implements iView
{
   protected array $article;
   
    public function __construct(array $article, string $wrapper)
    {
       $this->article = $article;
       $this->wrapper= $wrapper;
    }
    public function show() : void
    {
        if($_SESSION['UID'] == $this->article['author_id'])
        {
            echo '<a href="'.LINKBASE.'editarticle&article_id='.$this->article['id'].'">edit Article</a>';
        }
        if($this->article['tags'] || $this->article['tags'] == null) 
        {
            $this->article['tags'] = 'n/a'; // tag missing, to be fixed ! TO do
        }
        echo 
         '<'.$this->wrapper.'>'.PHP_EOL
        .'<div class="article_image">'.$this->article['img'].'</div>'.PHP_EOL
        .'<div class="article_title">'.$this->article['title'].'</div>'.PHP_EOL
        .'<div class="article_tag">'.$this->article['tags'].'</div>'.PHP_EOL
        .'<div class="article_date">'.$this->article['date_edit'].'</div>'.PHP_EOL
        .'<div class="article_author">'.$this->article['author_id'].'</div>'.PHP_EOL
        .'<div class="article_rate">'.$this->article['rating'].'</div>'.PHP_EOL
        .'<div class="article_text">'.$this->article['explanation'].'</div>'.PHP_EOL
        .'<div class="article_code">'.$this->article['code_block'].'</div>'.PHP_EOL
        .'</'.$this->wrapper.'>'.PHP_EOL
        ;
    }
}