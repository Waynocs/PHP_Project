<?php
include 'class/App.php';
include 'class/Auth.php';
include 'class/Session.php';
include 'class/Database.php';

$auth = App::getAuth(); //Récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD

$auth->restrict(); //Appel de la fonction restrict de la class Auth qui va amener à forcer l'utilisateur à changer de page (connexion.php) si !connecté

//Introduire dans la BdD des articles
if (isset($_POST["ecrire"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titre']) && !empty($_POST['theme']) && !empty($_POST['contenu'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titre = htmlentities($_POST['titre']); //htmlentities convertit tous les caractères éligibles en entités HTML
        $contenu = htmlentities($_POST['contenu']);
        $theme = htmlentities($_POST['theme']);
        $id_editor = $_SESSION['auth']->id_editor;

        $bdd->query("INSERT INTO news SET id_theme = ?, title_news = ?, date_news = NOW(), text_news = ?, id_editor = ?",  [$theme, $titre, $contenu, $id_editor]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        echo ("<p style='color: green;'> L'article à bien été posté à l'adresse : <a href='index.php' title='ici'> ici </a> </p>");
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire s'il vous plaît. </p>");
    }
}

?>

<html lang=\"fr\">

<head>

    <meta charset=\"UTF-8\" />
    <title> Compte </title>
    <link rel="stylesheet" href="../css/commun.css">
    <link rel="stylesheet" href="../css/compte.css">

</head>

<body>
    <header>

        <h1> <a href="compte.php">Compte</a> </h1>

    </header>
    <nav>
        <div class="button-align">
            <p><a href="index.php"><button class="news">Les news</button></a></p>
        </div>
        <div class="button-align">
            <p><a href="?deco"><button class="deconnexion"> Deconnexion </button></a></p>
        </div>
    </nav>

    <?php if (isset($_GET["deco"])) : ?>
        <style>
            body {
                opacity: 0.9;
            }
        </style>
        <div id="deco">
            <h3>Voulez-vous poursuivre la deconnexion ? </h3>
            <p><a href="deconnexion.php">Oui </a></p>

            <p><a href="compte.php">Non </a></p>
        </div>

    <?php
    endif;
    ?>



    <div id="center">
        <h2> Bonjour <?= $_SESSION["auth"]->name; ?>, bienvenue sur votre espace compte </h2><br />

        <h3>Vous possedez votre compte depuis le : <?=
                                                        date("d/m/y H:i:s", strtotime($_SESSION["auth"]->dateCreate)); ?></h3>
    </div>
    <br /><br />
    <div id="postArticle">
        <h3> possibilité de poster des news : </h3><br />
        <?php $reqThemes = $bdd->query("SELECT * FROM theme"); ?>

        <form method="POST">
            <label for="titre"> Le titre de votre article : </label> <!-- Label relié au champs input par le for de label et le name de input-->
            <input type="text" name="titre" placeholder="Le titre" /><br><br /> <!-- name = titre pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <label for="theme"> Le theme : </label>
            <select name="theme">
                <?php foreach ($reqThemes as $reqTheme) : ?>
                    <option value="<?= $reqTheme->id_theme ?>">
                        <?= $reqTheme->description ?>
                    </option>
                <?php endforeach; ?>
            </select><br /><br />
            <label for="contenu"> description de votre article : </label><br /><br /> <!-- Label relié au champs textarea par le for de label et le name de input-->
            <textarea name="contenu" placeholder="La description" rows="10" cols="50"></textarea><br /><br /> <!-- name = description pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <input type="submit" name="ecrire" value="Envoyer" /> <!-- name = ecrire pour pouvoir envoyer la methode $_POST -->
        </form>
    </div>
    <br /><br />

    <?php
    include 'inc/footer.php';
    ?>