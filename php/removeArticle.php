<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$session = new Session();

$auth = App::getAuth();
$bdd = App::getDatabase();

$auth->restrict();

if (isset($_GET['id_news'])) {
    $id_news = htmlentities($_GET['id_news']);
    $id_editor = $_SESSION['auth']->id_editor;
    $req_News = $bdd->query("delete FROM news  WHERE id_editor = ? AND id_news = ?", [$id_editor, $id_news]);
    if ($req_News) {
        $session->write('flash', "<p class='info flash'> L'article a bien été supprimé </p>");
    } else {
        $session->write('flash', "<p class='info flash'> Aucune suppression effectuée </p>");
    }
}
header('location:index.php');
exit();
