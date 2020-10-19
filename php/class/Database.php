<?php

class Database
{
    private $pdo;

    public function __construct($login, $password, $database_name, $host = 'localhost') //création de la BdD
    {
        $this->pdo = new PDO("mysql:dbname=$database_name;host=$host", $login, $password); //instancie la variable pdo par la BdD PDO corespondant à la BdD "projet"
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configuration de la BdD pour afficher les exceptions
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //Configuration de la BdD pour afficher les exceptions
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId(); //retourne le dernier identifiant inséré dans la BdD
    }

    public function query($query, $params = false)
    {
        if ($params) { //On regarde si il y'a un paramètre
            $req = $this->pdo->prepare($query); //prépare la requete sur le query
            $req->execute($params); //Puis on l'execute avec les parametres
        } else
            $req = $this->pdo->query($query); //On prépare et on éxecute en même temps la fonction

        return $req;
    }
}
