<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$session = new Session();

$auth = App::getAuth();
$bdd = App::getDatabase();

$auth->restrict();

if (isset($_GET['id_news']) && isset($_GET['visibility'])) {
    $id_news = htmlspecialchars($_GET['id_news']);
    $id_editor = $_SESSION['auth']->id_editor;
    $visibility = htmlspecialchars(!$_GET['visibility']);
    $req_News = $bdd->query("UPDATE news SET visibility = ? WHERE id_editor = ? AND id_news = ?", [$visibility, $id_editor, $id_news]);
    if ($req_News) {
        $session->write('flash', "<p class='info flash'> Le type de l'article a bien été changé </p>");
    } else {
        $session->write('flash', "<p class='info flash'> Aucune modification effectuée </p>");
    }
}
header('location:index.php');
die();
