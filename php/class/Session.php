<?php

class Session
{

    static $instance;

    static function getInstance() //permet de retourner l'instance (la session)
    {
        if (!self::$instance) //Vérifie si la variable n'a pas encore été instaciée
            self::$instance = new Session(); //instance de la session 

        return self::$instance;
    }

    public function __construct()
    {
        if (!isset($_SESSION)) //Si !session alors on en créé une
            session_start(); //création de la session, permet à l'utilisateur d'être connecté sur les pages
    }

    public function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null; //si il y'a une session avec le parametre key (Auth ici) alors on retourne la session, sinon null
    }

    public function delete($key)
    {
        unset($_SESSION[$key]); //Appel de la fonction unset qui permet de supprimer la session d parametre key (= Auth)
    }

    public function write($key, $value) //
    {
        $_SESSION[$key] = $value; //Session Auth est égal aux valeurs atribuées (celles de la Base de Donnée)
    }
}
