<?php

require_once 'i_Html_Element.php';
require_once "authorlistview.php";

class aboutView implements iView
{
   public function show() : void
    {
        // title: About
        // TODO: class aanmaken voor h1, toevoegen aan onderstaande
        echo "<h1>Over de wiki</h1>";

        // textarea: bodytext
        echo '<div class="bodycontent">Sinds haar conceptie in 1982 is deze Wiki een begrip onder developers uit alle windstreken. Kunt u het niet vinden op deze site, dan bestaat het simpelweg niet.</div>
        </br></br><div class="bodycontent">Stackoverwhat? Once you go Wiki, you never go panicki</br>- Linus Torvalds</div>
        </br></br><div class="bodycontent">We will never need more than 640kb of RAM or more than this Wiki</br>- Bill Gates</div>
        </br>';
        echo '<div class="authorlist-container"><div class="authorlist-item">Onze auteurs:</div></div>';

        // list: authors
        $authormodel = new SiteDAO();
        $authors = $authormodel->getAuthors();
        $authorlist = new AuthorListView($authors);
        $authorlist->show();
    }
}