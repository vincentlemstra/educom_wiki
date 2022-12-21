<?php
Abstract class BaseList implements iView 
{
protected array $items; //protected--> kan overschreven worden door extends

	public function __construct(array $items)
	{
		$this->items = $items;
	}

	final public function show() //in extend niet overschrijfbaar
	{
		$this->openList();
		$this->showItems();
		$this->closeList();
	}
	
	protected function showItems()
	{
		foreach($this->items as $item)
		{
			$this->showItem($item)
		}
	}
	abstract function openList();
	abstract function closeList();

}

class MenuView extends BaseList 
{
	protected function openList()
	{
		echo "<NAV>
					<UL>";
	}
	

	protected function showItem(array $item)
	{
		echo "<LI><A href="index.php/?page=$item['page']"> $item['title'] </A></LI>";
	}
	protected function closeList()
	{
		echo "	</UL>
						</DIV>";
	}
}

class AuthorList extends Baselist
	protected function showItem(array $item)
	{
		echo "<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI>";
	}

// zet alle classes in aparte bestanden en test de classes afzonderlijk.. 

//--> opsomming van Authors, met hyperlinks naar Authorpagina
//open Div
<DIV>
	<UL>
// walk
		<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI> trough elements and show
		<LI><A href="index.php/about/$author_Name"   id="$author_ID">$author_Name</A></LI>
		<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI>
		<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI>
		<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI>
		<LI><A href="index.php/authors/$author_Name" id="$author_ID">$author_Name</A></LI>
//Close list and DIV
	</UL>
</DIV>

//Open Nav
<NAV>
	<UL>
//Walk though elements and show
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
		<LI><A href="index.php/$menuitem" id=""> $menu_title </A></LI>
//Close
	</UL>
</NAV>

//Open Table
<TABLE>
	<TH>Sorteer op naam </TH><TH>Sorteer op Auteur</TH><TH>Sorteer op Tag</TH>Sorteer op datum<TH>sorteer op waardering</TH>
//Walk through elements and show
		<TR><TD><a href="index.php/articles/$article_name">$author_name</a></TD><TD>$article_Author</TD><TD>$article_tags</TD><TD>$article_date</TD><TD>$article_rating</TD></TR>
		<TR><TD><a href="index.php/articles/$article_name">$author_name</a></TD><TD>$article_Author</TD><TD>$article_tags</TD><TD>$article_date</TD><TD>$article_rating</TD></TR>
		<TR><TD><a href="index.php/articles/$article_name">$author_name</a></TD><TD>$article_Author</TD><TD>$article_tags</TD><TD>$article_date</TD><TD>$article_rating</TD></TR>
		<TR><TD><a href="index.php/articles/$article_name">$author_name</a></TD><TD>$article_Author</TD><TD>$article_tags</TD><TD>$article_date</TD><TD>$article_rating</TD></TR>
		<TR><TD><a href="index.php/articles/$article_name">$author_name</a></TD><TD>$article_Author</TD><TD>$article_tags</TD><TD>$article_date</TD><TD>$article_rating</TD></TR>
//Close Table
</TABLE>

//- Formulier: formuliervelden contact tonen
//wat is needed? 
//-->> Form fields
//-->> Postresults if filled and validated

//open Form
<form action="" method="POST" enctype="multipart/form-data" > //Open Form
 //Walk through all elements and show
	<input type="hidden" name="page" value="contact" />
	<label for="name">Je naam</label><br /> 
	<input type="text" name="name" placeholder="Vul hier je naam in" value="koen" " />
<br />
	<label for="email">Je email-adres</label><br />
	<input type="email" name="email" placeholder="Vul hier je email-adres in" value="koen@hoi.nl" " />
<br />
	<label for="phone">Je telefoonnummer</label><br />
	<input type="tel" name="phone" placeholder="Vul hier je telefoonnummer in" value="" " />
<br />
	<label for="message">Je bericht</label><br />
	<textarea name="message" placeholder="Vul hier je bericht in"></textarea>
<br />
	<label for="contact">Neem contact met op via</label><br /> 
	<select name="contact">
		<option value="contact_email" >Email</option>
		<option value="contact_phone" >Telefoon</option> 
		<option value="contact_pidgeon" >Postduif</option>
	</select>
<br />
//Sluit lijst
	<button type="submit" value="submit">Versturen</button>
</form> //close Form