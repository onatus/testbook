<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once 'controller.php';
require_once 'mapper.php';
require_once 'book.php';

$dsn = 'mysql:dbname=library;host=127.0.0.1';
$user = 'root';                //логин для подключения к MySQL
$password = '';                //пароль

try {
    $dbh = new \PDO($dsn, $user, $password);
} catch (\PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//var_dump($_POST);

$controller = new Controller;
$mapper = new Mapper($dbh);
/*$controller->showBook($mapper->getSome(8), $mapper);*/
//var_dump($mapper->getSome(4));


if($_POST['show']=='all'){
   $controller->showAll($mapper->getAll(),$mapper);
}
if($_POST['comment']){
    //var_dump($_POST);
    $mapper->setComment($_POST['id'], $_POST['comment']);
    $controller->showComments($mapper->getComments($_POST['id']));
}

/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 29.06.2015
 * Time: 14:38
 */