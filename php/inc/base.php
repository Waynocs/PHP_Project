<?php
$auth = App::getAuth(); //Récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD
$session = new Session();
if (isset($_GET["deco"])) { ?>

    <div id="deco">
        <h3 style="color:white;">Voulez-vous poursuivre la deconnexion ? </h3>
        <p><a href="deconnexion.php">Oui</a></p>

        <p><a href="<?= "http://$_SERVER[HTTP_HOST]" . explode('?', $_SERVER['REQUEST_URI'], 2)[0] ?>">Non</a></p>
    </div>
<?php }
