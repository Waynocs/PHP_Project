<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$session = new Session();

$auth = App::getAuth(); //recupere l'Auth
$bdd = App::getDatabase(); //Récupere la bdd 

if ($auth->user()) //appel la fonction user dans la class Auth pour savoir si l'utilisateur est deja connecté. Si oui : oblige l'utilisateur à etre redirigé par le header vers compte.php
{
    header('Location: compte.php');
    exit();
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


<html lang="fr">

<head>
    <link type="text/css" rel="stylesheet" href="../css/commun.css">
    <link type="text/css" rel="stylesheet" href="../css/connexion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>
        Page connexion
    </title>
</head>

<body>
    <header>

        <h1>
            <a href="connexion.php">
                Connexion/Inscription
            </a>
        </h1>

    </header>
    <nav>
        <p>
            <a href="index.php">
                <button>
                    Les news
                </button>
            </a>
        </p>
    </nav>
    <?php
        if ($session->read('flash')) {
            echo $session->read('flash');
            $session->delete('flash');
        }
        ?>

    
    <div id="connexion">
        <form method="POST">
            <h2>
                Se connecter :
            </h2>
            <br />
            <label for="mailConnexion">
                Adresse mail :
            </label>
            <input type="text" name="mailConnexion" minlenght="4" maxlenght="16" placeholder="Adresse-mail" <?php if (isset($_POST['mailConnexion'])) : ?> value="<?= $_POST['mailConnexion']; ?>" <?php endif; ?> />
            <br />
            <br />
            <label for="mdpConnexion">
                Mot de passe :
            </label>
            <input type="password" name="mdpConnexion" placeholder="mot de passe" <?php if (isset($_POST['mdpConexxion'])) : ?> value="<?= $_POST['mdpConexxion']; ?>" <?php endif; ?> />
            <br />
            <br />
            <input type="submit" name="connexion" value="Se connecter" />
            <br />
            <br />
            <p>Pas encore de compte ? <a href ="inscription.php">S'inscrire</a>
            </form>
    </div>
    
    <br />
    <br />

    <?php
    include_once 'inc/footer.php';
    ?>


</body>

</html>