<?php
include 'class/App.php';
include 'class/Auth.php';
include 'class/Session.php';
include 'class/Database.php';

$session = new Session();

$auth = App::getAuth(); //recupere l'Auth
$bdd = App::getDatabase(); //Récupere la bdd 

if ($auth->user()) //appel la fonction user dans la class Auth pour savoir si l'utilisateur est deja connecté. Si oui : oblige l'utilisateur à etre redirigé par le header vers compte.php
{
    header('Location: compte.php');
    exit();
}

if (isset($_POST['inscription'])) { //Si bouton inscription validé, la codition est remplie
    if (!empty($_POST['prenomInscription']) && !empty($_POST['nomInscription']) && !empty($_POST['mailInscription']) && !empty($_POST['mdpInscription']) && !empty($_POST['mdpConfirmerInscription'])) { //Si les 3 champs !vide
        if ($_POST['mdpInscription'] === $_POST['mdpConfirmerInscription']) { //On vérifie si les deux champs sont égaux 
            $mailInscription = mb_strtolower(htmlentities($_POST['mailInscription'])); //mb_strtolower mettre la chaine de caractere en minuscule pour pouvoir comparer avec la BdD si le pseudonyme est déjà pris
            $prenomInscription = htmlentities($_POST['prenomInscription']);
            $nomInscription = htmlentities($_POST['nomInscription']);

            if (filter_var($mailInscription, FILTER_VALIDATE_EMAIL)) {
                if (strlen($prenomInscription) >= 4 && strlen($prenomInscription) <= 16) { //Vérifie si le pseudonyme se trouve entre 4 et 16 caractères
                    $mdpInscription = password_hash(htmlentities($_POST['mdpInscription']), PASSWORD_DEFAULT); //Appel de la fonction password_hash de parametre le mdp d'inscription, et PASSWORD_DEFAULT qui est le type de hashage (cryptage)
                    $reqUser = $bdd->query("SELECT id_editor FROM editor WHERE mail_address = ?", [$mailInscription])->fetch(); //Appel de la fonction query de la classe Database (va executer avec la fonction fetch pour pouvoir afficher les informations en objet)
                    if (!$reqUser) { //Si aucun retour de la requete, alors le pseudonyme n'est pas déjà pris dans la BdD
                        $auth->register($bdd, $nomInscription, $prenomInscription, $mailInscription, $mdpInscription); //Appel de la fonction register de la classe auth

                        header('Location: compte.php'); //redirige l'utilisateur sur la page compte.php
                        exit(); //Dis explicitement que le script est bien terminé
                    } else {
                        echo ("<p style='color: red;'> Votre email est déjà pris. </p>");
                    }
                } else {
                    echo ("<p style='color: red;'> Votre prenom doit être entre 4 et 16 caractères. </p>");
                }
            } else {
                echo ("<p style='color: red;'> Votre email est invalide </p>");
            }
        } else {
            echo ("<p style='color: red;'> Les deux mots de passe ne correspondent pas. </p>");
        }
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire s'il vous plaît. </p>");
    }
}


if (isset($_POST['connexion'])) { //Si bouton connexion validé, la codition est remplie
    if (!empty($_POST['mailConnexion']) && !empty($_POST['mdpConnexion'])) { //Si les 2 champs !vide
        $mdpConnexion = htmlentities($_POST['mdpConnexion']);
        $mailConnexion = mb_strtolower(htmlentities($_POST['mailConnexion']));
        if ($auth->login($bdd, $mailConnexion, $mdpConnexion)) { //Appel de la fonction login de parametre bdd, pseudoConnexion et mdpConnexion dans la class Auth.php, retourne true si la connexion s'est faite, pour pouvoir rediriger l'utilisateur
            {
                header('Location: compte.php');
                exit();
            }
        } else {
            echo ("<p style='color: red;'> Le mot de passe ou l'identifiant ne correspond pas. </p>");
        }
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire s'il vous plaît. </p>");
    }
}
?>


<html lang=\"fr\">

<head>
    <link type="text/css" rel="stylesheet" href="../css/commun.css">
    <link type="text/css" rel="stylesheet" href="../css/connexion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset=\"UTF-8\" />
    <title> Page connexion </title>
</head>

<body>
    <header>

        <h1> <a href="connexion.php"> Connexion/Inscription</a> </h1>

    </header>
    <nav>
        <p><a href="index.php"><button>Les news</button></a></p>
    </nav>

    <div id="inscription">
        <form method="POST">
            <h2> S'inscrire : </h2>
            <label for="prenomInscription"> Prénom : </label>
            <input type="text" name="prenomInscription" minlenght="4" maxlenght="16" placeholder="Prénom" <?php if (isset($_POST['prenomInscription'])) : ?> value="<?= $_POST['prenomInscription']; ?>" <?php endif; ?>> <br /><br />
            <label for="nomInscription"> Nom : </label>
            <input type="text" name="nomInscription" minlenght="4" maxlenght="16" placeholder="Nom" <?php if (isset($_POST['nomInscription'])) : ?> value="<?= $_POST['nomInscription']; ?>" <?php endif; ?>> <br /><br />
            <label for="mailInscription"> Adresse-mail : </label>
            <input type="text" name="mailInscription" minlenght="4" maxlenght="16" placeholder="Adresse-mail" <?php if (isset($_POST['mailInscription'])) : ?> value="<?= $_POST['mailInscription']; ?>" <?php endif; ?>> <br /><br />
            <label for="mdpInscription"> Mot de passe : </label>
            <input type="password" name="mdpInscription" placeholder="mot de passe" <?php if (isset($_POST['mdpInscription'])) : ?> value="<?= $_POST['mdpInscription']; ?>" <?php endif; ?>><br /><br />
            <label for="mdpConfirmerInscription"> Confirmer Mot de passe : </label>
            <input type="password" name="mdpConfirmerInscription" placeholder="confirmation mot de passe" <?php if (isset($_POST['mdpConfirmerInscription'])) : ?> value="<?= $_POST['mdpConfirmerInscription']; ?>" <?php endif; ?>>
            <br /><br />
            <input type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
    <br /><br />
    <div id="connexion">
        <form method="POST">
            <h2> Se connecter : </h2>
            <label for="mailConnexion"> Adresse mail : </label>
            <input type="text" name="mailConnexion" minlenght="4" maxlenght="16" placeholder="Adresse-mail" <?php if (isset($_POST['mailConnexion'])) : ?> value="<?= $_POST['mailConnexion']; ?>" <?php endif; ?>> <br /><br />
            <label for="mdpConnexion"> Mot de passe : </label>
            <input type="password" name="mdpConnexion" placeholder="mot de passe" <?php if (isset($_POST['mdpConexxion'])) : ?> value="<?= $_POST['mdpConexxion']; ?>" <?php endif; ?>><br /><br />
            <input type="submit" name="connexion" value="Se connecter">
    </div>
    </form><br /><br />

    <?php
    include 'inc/footer.php';
    ?>


</body>

</html>