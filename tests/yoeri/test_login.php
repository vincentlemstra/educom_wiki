<?php
require_once "crud.php";
require_once "AuthorModel.php";

session_start();

$crud = new Crud();

$testmodel = new AuthorModel($crud);


// testdata (zie test_authormodel.php)
$author = array(
    'firstname'=>'A',
    'preposition'=>'B',
    'lastname'=>'C',
    'email' => 'D@test.nl',
    'date_birth' => '1901-01-01',
    'password' => 'gaatjeniksaan',
    );

$response = $testmodel->handleLogin($author);

echo "_SESSION contents</br>";
var_dump($_SESSION);
echo "</br>_response contents</br>";
var_dump($response);

?>