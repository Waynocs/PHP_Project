<?php
include 'class/App.php';
include 'class/Auth.php';
include 'class/Session.php';

$session = new Session();
App::getAuth()->logout(); //Appel de la fonction logout de la class Auth

$session->write('flash', "<p style='color: green;'> Vous avez bien été déconnecté</p>");

header('Location: index.php'); //redirection forcée vers connexion.php
exit(); //exit obligatoire après un header
