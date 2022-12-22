<?php
require_once 'baselist.class.php';
class ArticleListView extends BaseList 
{
	public function openList()
	{
		echo "<TABLE><TH>Sorteer op naam </TH><TH>Sorteer op Auteur</TH><TH>Sorteer op Tag</TH><TH>Sorteer op datum</TH><TH>Sorteer op waardering</TH>";
	}

	public function showItem(array $item)
	{
		echo '<TR><TD><a href="index.php/articles/'.$item['title'].'">'.$item['title'].'</a>
				</TD><TD>'.$item['author'].'</TD>
				<TD>'.$item['tag'].'</TD>
				<TD>'.$item['date_modified'].'</TD>
				<TD>'.$item['beoordeling'].'</TD>
				</TR>';
	}
	
	public function closeList()
	{
		echo "</TABLE>";
	}
}