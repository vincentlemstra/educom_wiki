<?php
require_once "crud.php";
require_once "AuthorModel.php";

$crud = new Crud();
$testmodel = new AuthorModel($crud);

//===========================================================
// testdata: LET OP id aanpassen aan het id van het testrecord uit je eigen dbase!
$author = array(
    'firstname'=>'A',
    'preposition'=>'B',
    'lastname'=>'C',
    'email' => 'D@test.nl',
    'date_birth' => '1901-01-01',
    'password' => 'gaatjeniksaan',
    'id'=> '11'
    );

    // echo "</br></br>input array:</br>";
    // var_dump($author);

//===========================================================

$data1 = $testmodel->getAllAuthors();

echo "getAllAuthors output:</br>";
var_dump($data1);

//===========================================================

$data2 = $testmodel->getAllAuthorNames();

echo "</br></br>getAllAuthorNames output:</br>";
var_dump($data2);

//===========================================================

$data3 = $testmodel->getAuthorById($author['id']);

echo "</br></br>getAuthorById output:</br>";
var_dump($data3);

//===========================================================

$data4 = $testmodel->getAuthorByEmail($author['email']);

echo "</br></br>getAuthorByEmail output:</br>";
var_dump($data4);

//===========================================================

// TEST FOR DELETEAUTHOR: SUCCES
// var_dump ($testmodel->deleteAuthor($author));

// TEST FOR UPDATEAUTHOR: SUCCES
// var_dump ($testmodel->updateAuthor($author));

// TEST FOR CREATEAUTHOR: SUCCES
// var_dump ($testmodel->createAuthor($author));

?>