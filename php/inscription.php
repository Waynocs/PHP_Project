<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

include("./inc/base.php");

if ($auth->user()) //appel la fonction user dans la class Auth pour savoir si l'utilisateur est deja connecté. Si oui : oblige l'utilisateur à etre redirigé par le header vers compte.php
{
    header('Location: compte.php');
    exit();
}

if (isset($_POST['inscription'])) { //Si bouton inscription validé, la condition est remplie
    if (!empty($_POST['prenomInscription']) && !empty($_POST['nomInscription']) && !empty($_POST['mailInscription']) && !empty($_POST['mdpInscription']) && !empty($_POST['mdpConfirmerInscription'])) { //Si les 3 champs !vide
        if ($_POST['mdpInscription'] === $_POST['mdpConfirmerInscription']) { //On vérifie si les deux champs sont égaux 
            $mailInscription = mb_strtolower(htmlentities($_POST['mailInscription'])); //mb_strtolower mettre la chaine de caractere en minuscule pour pouvoir comparer avec la BdD si le mail est déjà pris
            $prenomInscription = htmlentities($_POST['prenomInscription']);
            $nomInscription = htmlentities($_POST['nomInscription']);

            if (filter_var($mailInscription, FILTER_VALIDATE_EMAIL)) {
                if (strlen($prenomInscription) >= 3 && strlen($prenomInscription) <= 24) { //Vérifie si le prenom se trouve entre 4 et 16 caractères
                    if (strlen($nomInscription) >= 3 && strlen($nomInscription) <= 24) {
                        if (strlen($_POST['mdpInscription']) >= 6 && strlen($_POST['mdpInscription']) <= 50) {
                            $mdpInscription = password_hash(htmlentities($_POST['mdpInscription']), PASSWORD_DEFAULT); //Appel de la fonction password_hash de parametre le mdp d'inscription, et PASSWORD_DEFAULT qui est le type de hashage (cryptage)
                            $reqUser = $bdd->query("SELECT id_editor FROM editor WHERE mail_address = ?", [$mailInscription])->fetch(); //Appel de la fonction query de la classe Database (va executer avec la fonction fetch pour pouvoir afficher les informations en objet)
                            if (!$reqUser)  //Si aucun retour de la requete, alors le mail n'est pas déjà pris dans la BdD
                            {
                                $auth->register($bdd, $nomInscription, $prenomInscription, $mailInscription, $mdpInscription); //Appel de la fonction register de la classe auth

                                header('Location: compte.php'); //redirige l'utilisateur sur la page compte.php
                                exit(); //Dis explicitement que le script est bien terminé
                            } else
                                echo ("<p style='color: red;'> Votre email est déjà pris. </p>");
                        } else
                            $session->write("flash", " <p style='color: red;'> Votre mot de passe doit être entre 6 et 50 caractères. </p>");
                    } else
                        echo ("<p style='color: red;'> Votre nom doit être entre 3 et 24 caractères. </p>"); //faire flash

                } else
                    echo ("<p style='color: red;'> Votre prenom doit être entre 3 et 24 caractères. </p>"); //faire flash

            } else
                echo ("<p style='color: red;'> Votre email est invalide </p>"); //faire flash

        } else
            echo ("<p style='color: red;'> Les deux mots de passe ne correspondent pas. </p>"); //faire flash

    } else
        echo ("<p style='color: red;'> Veuillez remplir le formulaire s'il vous plaît. </p>"); //faire flash

}
?>

<html lang="fr">

<head>
    <style>
        <?php
        include("./inc/style.php");
        ?>
    </style>
    <link type="text/css" rel="stylesheet" href="../css/style.css">
    <link type="text/css" rel="stylesheet" href="../css/connexion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>
        Page Inscription
    </title>
</head>

<body>
    <?php
    $title = "Inscription";
    include("./inc/header.php");
    ?>
    <main>
        <?php
        if ($session->read('flash')) {
            echo $session->read('flash');
            $session->delete('flash');
        }
        ?>
        <?php
        if ($session->read('flash')) {
            echo $session->read('flash');
            $session->delete('flash');
        }
        ?>

        <div id="inscription">
            <form method="POST">
                <h2>
                    S'inscrire :
                </h2>
                <br />
                <label for="prenomInscription">
                    Prénom :
                </label>
                <input type="text" name="prenomInscription" minlenght="4" maxlenght="16" placeholder="Prénom" <?php if (isset($_POST['prenomInscription'])) : ?> value="<?= $_POST['prenomInscription']; ?>" <?php endif; ?> />
                <br />
                <br />
                <label for="nomInscription">
                    Nom :
                </label>
                <input type="text" name="nomInscription" minlenght="4" maxlenght="16" placeholder="Nom" <?php if (isset($_POST['nomInscription'])) : ?> value="<?= $_POST['nomInscription']; ?>" <?php endif; ?> />
                <br />
                <br />
                <label for="mailInscription">
                    Adresse-mail :
                </label>
                <input type="text" name="mailInscription" minlenght="4" maxlenght="16" placeholder="Adresse-mail" <?php if (isset($_POST['mailInscription'])) : ?> value="<?= $_POST['mailInscription']; ?>" <?php endif; ?> />
                <br />
                <br />
                <label for="mdpInscription">
                    Mot de passe :
                </label>
                <input type="password" name="mdpInscription" placeholder="mot de passe" <?php if (isset($_POST['mdpInscription'])) : ?> value="<?= $_POST['mdpInscription']; ?>" <?php endif; ?> />
                <br />
                <br />
                <label for="mdpConfirmerInscription">
                    Confirmer Mot de passe :
                </label>
                <input type="password" name="mdpConfirmerInscription" placeholder="confirmation mot de passe" <?php if (isset($_POST['mdpConfirmerInscription'])) : ?> value="<?= $_POST['mdpConfirmerInscription']; ?>" <?php endif; ?> />
                <br />
                <br />
                <input type="submit" name="inscription" value="S'inscrire" class="button" />
                <br />
                <br />
                <p>Déjà inscrit ? <a href="connexion.php">Connexion</a></p>
            </form>
        </div>

        <br />
        <br />

        <?php
        include_once 'inc/footer.php';
        ?>


</body>

</html>