<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

include_once("./inc/base.php");
$auth->restrict(); //Appel de la fonction restrict de la class Auth qui va amener à forcer l'utilisateur à changer de page (connexion.php) si !connecté
//Introduire dans la BdD des articles
if (isset($_POST["ecrireArticle"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titreArticle']) && !empty($_POST['themeArticle']) && !empty($_POST['langueArticle']) && isset($_POST['visibility']) && !empty($_POST['contenuArticle'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titreArticle = htmlspecialchars($_POST['titreArticle']); //htmlspecialchars convertit tous les caractères éligibles en entités HTML
        $themeArticle = htmlspecialchars($_POST['themeArticle']);
        $langueArticle = htmlspecialchars($_POST['langueArticle']);
        $visibility = htmlspecialchars($_POST['visibility']);
        $contenuArticle = htmlspecialchars($_POST['contenuArticle']);
        $id_editor = $_SESSION['auth']->id_editor;

        $bdd->query("INSERT INTO news SET id_theme = ?, id_langue = ?, visibility = ?, title_news = ?, date_news = NOW(), text_news = ?, id_editor = ?",  [$themeArticle, $langueArticle, $visibility, $titreArticle, $contenuArticle, $id_editor]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> L'article à bien été posté à l'adresse : <a href='index.php' title='ici'> ici </a> </p>");
        header('Location: compte.php');
        die();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire article s'il vous plaît. </p>");
    }
}

//Introduire dans la BdD des articles
if (isset($_POST["ecrireTheme"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titreTheme']) && !empty($_POST['descriptionTheme'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titreTheme = htmlspecialchars($_POST['titreTheme']); //htmlspecialchars convertit tous les caractères éligibles en entités HTML
        $descriptionTheme = htmlspecialchars($_POST['descriptionTheme']);
        $couleurTheme = substr(htmlspecialchars($_POST['couleurTheme']), 1);
        $bdd->query("INSERT INTO theme SET title = ?, description = ?, color = ?",  [$titreTheme, $descriptionTheme, $couleurTheme]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> Le thème à bien été enregistré </p>");
        header('Location: compte.php');
        die();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire thème s'il vous plaît. </p>");
    }
}

//Introduire dans la BdD des articles
if (isset($_POST["ecrireLangue"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titleLangue'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titleLangue = htmlspecialchars($_POST['titleLangue']); //htmlspecialchars convertit tous les caractères éligibles en entités HTML

        $bdd->query("INSERT INTO langue SET title = ?",  [$titleLangue]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> La langue à bien été enregistrée </p>");
        header('Location: compte.php');
        die();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire langue s'il vous plaît. </p>");
    }
}

?>

<html lang="fr">

<head>

    <meta charset="UTF-8" />
    <title>
        Compte
    </title>
    <style>
        <?php
        include_once("./inc/style.php");
        ?>
    </style>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/compte.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <?php
    $title = "Compte";
    include_once("./inc/header.php");
    ?>
    <?php
    if ($session->read('flash')) {
        echo $session->read('flash');
        $session->delete('flash');
    }
    ?>

    <?php $reqThemes = $bdd->query("SELECT * FROM theme"); ?>
    <?php $reqLangues = $bdd->query("SELECT * FROM langue"); ?>

    <div id="center">
        <h2>
            Bonjour <?= $_SESSION["auth"]->name; ?>, bienvenue sur votre espace compte
        </h2>
        <br />

        <h3>
            Vous possedez votre compte depuis le : <?= date("d/m/y H:i:s", strtotime($_SESSION["auth"]->dateCreate)); ?>
        </h3>
    </div>
    <br />
    <br />

    <div id="newsThemeLangue">
        <p id="news" class="button">
            Ecrire des news
        </p>
        <p id="theme" class="button">
            Ecrire un theme
        </p>
        <p id="langue" class="button">
            Ecrire une langue
        </p>
    </div>

    <div id="postArticle">
        <h3>
            possibilité de poster des news :
        </h3>
        <br />

        <form method="POST">
            <label for="titreArticle">
                Le titre de votre article :
            </label>
            <input type="text" name="titreArticle" placeholder="Le titre" />
            <br />
            <br />
            <label for="themeArticle">
                Le theme :
            </label>
            <select name="themeArticle">
                <?php foreach ($reqThemes as $reqTheme) : ?>
                    <option title="Description : <?= $reqTheme->description; ?>" value="<?= $reqTheme->id_theme ?>">
                        <?= $reqTheme->title ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br />
            <br />
            <label for="langueArticle">
                La langue :
            </label>
            <select name="langueArticle">
                <?php foreach ($reqLangues as $reqLangue) : ?>
                    <option value="<?= $reqLangue->id_langue ?>">
                        <?= $reqLangue->title ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br />
            <br />

            <label for="visibility">
                Visibilité :
            </label>
            <select name="visibility">
                <option title="Public" value="1">
                    Public
                </option>
                <option title="Privé" value="0">
                    Privé
                </option>
            </select>

            <br />
            <br />


            <label for="contenuArticle">
                description de votre article :
                <span class="pop-info">
                    ?
                    <div>
                        Formattage : <br />
                        <span class="info">[g]...[/g]</span> : en gras<br />
                        <span class="info">[i]...[/i]</span> : en italique<br />
                        <span class="info">[t]...[/t]</span> : sous-titre
                    </div>
                </span>
            </label>
            <br />
            <br />
            <textarea name="contenuArticle" placeholder="La description" rows="10" cols="50"></textarea>
            <br />
            <br />
            <input type="submit" name="ecrireArticle" value="Envoyer" class="info button" />
        </form>

    </div>

    <div id="postTheme">
        <h3>
            possibilité de poster des themes :
        </h3>
        <br />

        <script type="text/javascript" src="./scripts/escapeHtml"></script>
        <script type="text/javascript">
            function onColorChange() {
                var blank = document.getElementById("preview-blank");
                var theme = document.getElementById("preview-theme");
                var picker = document.getElementById("color-picker");
                blank.style.backgroundColor = picker.value;
                theme.style.backgroundColor = picker.value;
            }

            function onThemeChange() {
                var theme = document.getElementById("preview-theme");
                var title = document.getElementById("theme-title");
                theme.innerHTML = title.value;
            }
        </script>
        <form method="POST">
            <label for="titreTheme">
                Le titre de votre theme :
            </label>
            <input type="text" onchange="onThemeChange()" id="theme-title" name="titreTheme" placeholder="Le titre" />
            <br />
            <br />
            <label for="titreTheme">
                La couleur votre theme :
            </label>
            <input id="color-picker" type="color" value="#ff0000" name="couleurTheme" onchange="onColorChange()" />
            <span class="force-light pop-info">
                ?
                <div>
                    <div id="preview-blank" style="background-color: red;"></div>
                    <span id="preview-theme" style="font-style: italic; background-color: red;padding: .5rem;"></span>
                </div>
            </span>
            <br />
            <br />

            <label for="descriptionTheme">
                Description de votre theme :
            </label>
            <br />
            <br />
            <textarea name="descriptionTheme" placeholder="La description" rows="10" cols="50"></textarea>
            <br />
            <br />
            <input type="submit" name="ecrireTheme" value="Envoyer" class="info button" />
        </form>
    </div>

    <div id="postLangue">
        <h3>
            possibilité de poster des langues :
        </h3>
        <br />


        <form method="POST">
            <label for="titleLangue">
                La langue :
            </label>
            <input type="text" name="titleLangue" placeholder="Le titre de la langue" />
            <br />
            <br />
            <input type="submit" name="ecrireLangue" value="Envoyer" class="info button" />
        </form>

    </div>

    <?php
    include_once 'inc/footer.php';
    ?>

    <script type="text/javascript" src="scripts/toggle.js"></script>

</body>

</html>