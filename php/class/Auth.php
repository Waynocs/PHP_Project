<?php

class Auth
{
    private $session; //variable stockant la session

    public function __construct($session) //On met en paramètre l'objet session
    {
        $this->session = $session;
    }

    public function restrict()
    {
        if (!$this->session->read('auth')) { //On appel la fonction read de parametre auth de la classe session our savoir si l'utilisateur est connecté : true
            header('Location: connexion.php'); //renvoi vers connexion.php
            die(); //A mettre après un header
        }
    }

    public function connect($editor) //parametre du redacteur 
    {
        $this->session->write('auth', $editor); //Appel de la fonction Write de la classe session pour pouvoir ecrire une nouvelle session intitulé Auth, contenant les informtations editor (Toutes les infos)
    }

    public function logout()
    {
        $this->session->delete('auth'); //Appel de la fonction delete de paramètre Auth, de la class session
    }

    public function register($bdd, $nom, $prenom, $mail, $password) //bdd -> varaibale contenant la connexion à la BdD
    {
        $bdd->query("INSERT INTO editor SET surname = ?, name = ?, mail_address = ?, password = ?, dateCreate=NOW()", [$nom, $prenom, $mail, $password]); //Appel la fonction query de la class Database pour insérer le nouveau rédacteur
        $editor = $bdd->query("SELECT * FROM editor WHERE mail_address = ?", [$mail])->fetch(); //Appel de la fonction query de la classe Database pour séléctionner tous les attibuts de la table editor du redacteur, puis utilsation de la fonction fetch pour retourner un objet

        $this->connect($editor); //Appel de la fonction connect de parametre editor
    }

    public function login($bdd, $mail, $password)
    {
        $editor = $bdd->query("SELECT * FROM editor WHERE mail_address = ?", [$mail])->fetch(); //Appel de la fonction query de la classe Database pour sélectionner tous les attributs de la table editor en fonction du surname (Primary key), puis utilsation de la fonction fetch pour retourner un objet
        if ($editor) { //si la variable editor renvoi true alors on a trouvé un compte ayant le meme surname rentré en parametre 
            if (password_verify($password, $editor->password)) { //Appel de la fonction password_verify ayant pour premier parametre le password du fomulaire (non crypté) et pour deuxieme parametre le password correspondant au compte du redacteur (crypté)
                $this->connect($editor); //Appel de la fonction connect de parametre editor, editor comprenant tous les attributs du redacteur pour pouvoir créer la session correspondant


                return $editor; //Retourne editor si connecté
            } else
                return false;
        }
    }

    public function user() //lis l'Auth
    {
        if (!$this->session->read('auth')) //Appel de la fonction Read de paramètre Auth de la Class session, retourne false si !session
            return false;

        return $this->session->read('auth');
    }
}
