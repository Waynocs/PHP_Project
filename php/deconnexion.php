<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';

$session = new Session();
App::getAuth()->logout(); //Appel de la fonction logout de la class Auth

$session->write('flash', "<p style='color: green;'> Vous avez bien été déconnecté</p>");

header('Location: index.php'); //redirection forcée vers connexion.php
die(); //die obligatoire après un header
