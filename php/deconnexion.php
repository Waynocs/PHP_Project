<?php
include 'class/App.php';
include 'class/Auth.php';
include 'class/Session.php';

App::getAuth()->logout(); //Appel de la fonction logout de la class Auth

header('Location: index.php'); //redirection forcée vers connexion.php
exit(); //exit obligatoire après un header
