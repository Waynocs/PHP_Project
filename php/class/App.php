<?php

class App
{
    static $dbUsers = null; //variable stockant la connexion à la bdd 

    static function getDatabase()
    {
        if (!self::$dbUsers) //Vérifie si la variable n'a pas encore été instaciée
            self::$dbUsers = new Database('root', '', 'projet_php'); //Instance de la bdd de paramètre "identifiant de phpmyadmin + mot de passe + nom BdD + host = localhost si non rempli"



        return self::$dbUsers; //retourne le PDO
    }

    static function getAuth()
    {
        return new Auth(Session::getInstance()); //retourne l'objet Auth
    }
}
