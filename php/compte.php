<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$auth = App::getAuth(); //Récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD
$session = new Session();

$auth->restrict(); //Appel de la fonction restrict de la class Auth qui va amener à forcer l'utilisateur à changer de page (connexion.php) si !connecté

if (isset($_GET["deco"])) { ?>

    <div id="deco">
        <h3>Voulez-vous poursuivre la deconnexion ? </h3>
        <p><a href="deconnexion.php">Oui </a></p>

        <p><a href="compte.php">Non </a></p>
    </div>
<?php }

//Introduire dans la BdD des articles
if (isset($_POST["ecrireArticle"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titreArticle']) && !empty($_POST['themeArticle']) && !empty($_POST['langueArticle']) && !empty($_POST['contenuArticle'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titreArticle = htmlentities($_POST['titreArticle']); //htmlentities convertit tous les caractères éligibles en entités HTML
        $contenuArticle = htmlentities($_POST['contenuArticle']);
        $themeArticle = htmlentities($_POST['themeArticle']);
        $langueArticle = htmlentities($_POST['langueArticle']);
        $id_editor = $_SESSION['auth']->id_editor;

        $bdd->query("INSERT INTO news SET id_theme = ?, id_langue = ?, title_news = ?, date_news = NOW(), text_news = ?, id_editor = ?",  [$themeArticle, $langueArticle, $titreArticle, $contenuArticle, $id_editor]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> L'article à bien été posté à l'adresse : <a href='index.php' title='ici'> ici </a> </p>");
        header('Location: compte.php');
        exit();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire article s'il vous plaît. </p>");
    }
}

//Introduire dans la BdD des articles
if (isset($_POST["ecrireTheme"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titreTheme']) && !empty($_POST['descriptionTheme'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titreTheme = htmlentities($_POST['titreTheme']); //htmlentities convertit tous les caractères éligibles en entités HTML
        $descriptionTheme = htmlentities($_POST['descriptionTheme']);

        $bdd->query("INSERT INTO theme SET title = ?, description = ?",  [$titreTheme, $descriptionTheme]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> Le thème à bien été enregistré </p>");
        header('Location: compte.php');
        exit();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire thème s'il vous plaît. </p>");
    }
}

//Introduire dans la BdD des articles
if (isset($_POST["ecrireLangue"])) { //Si bouton "ecrire" utilisé, on rempli la condition et on rentre dans le second if
    if (!empty($_POST['titleLangue'])) { //Regarde si le titre ainsi que le contenu n'est pas vide
        $titleLangue = htmlentities($_POST['titleLangue']); //htmlentities convertit tous les caractères éligibles en entités HTML

        $bdd->query("INSERT INTO langue SET title = ?",  [$titleLangue]); //appel de la fonction query de parametre tableau titre et contenu, de la class Database.php

        $session->write('flash', "<p style='color: green;'> La langue à bien été enregistrée </p>");
        header('Location: compte.php');
        exit();
    } else {
        echo ("<p style='color: red;'> Veuillez remplir le formulaire langue s'il vous plaît. </p>");
    }
}

?>

<html lang="fr">

<head>

    <meta charset="UTF-8" />
    <title> Compte </title>
    <link rel="stylesheet" href="../css/commun.css">
    <link rel="stylesheet" href="../css/compte.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <?php
    if ($session->read('flash')) {
        echo $session->read('flash');
        $session->delete('flash');
    }
    ?>

    <?php $reqThemes = $bdd->query("SELECT * FROM theme"); ?>
    <?php $reqLangues = $bdd->query("SELECT * FROM langue"); ?>

    <div id="center">
        <h2> Bonjour <?= $_SESSION["auth"]->name; ?>, bienvenue sur votre espace compte </h2><br />

        <h3>Vous possedez votre compte depuis le : <?= date("d/m/y H:i:s", strtotime($_SESSION["auth"]->dateCreate)); ?></h3>
    </div>
    <br /><br />

    <div id="newsThemeLangue">
        <p id="news">Ecrire des news</p>
        <p id="theme">Ecrire un theme</p>
        <p id="langue">Ecrire une langue</p>
    </div>

    <div id="postArticle">
        <h3> possibilité de poster des news : </h3><br />

        <form method="POST">
            <label for="titreArticle"> Le titre de votre article : </label> <!-- Label relié au champs input par le for de label et le name de input-->
            <input type="text" name="titreArticle" placeholder="Le titre" /><br><br /> <!-- name = titre pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <label for="themeArticle"> Le theme : </label>
            <select name="themeArticle">
                <?php foreach ($reqThemes as $reqTheme) : ?>
                    <option title="Description : <?= $reqTheme->description; ?>" value="<?= $reqTheme->id_theme ?>">
                        <?= $reqTheme->title ?>
                    </option>
                <?php endforeach; ?>
            </select><br /><br />

            <label for="langueArticle"> La langue : </label>
            <select name="langueArticle">
                <?php foreach ($reqLangues as $reqLangue) : ?>
                    <option value="<?= $reqLangue->id_langue ?>">
                        <?= $reqLangue->title ?>
                    </option>
                <?php endforeach; ?>
            </select><br /><br />

            <label for="contenuArticle"> description de votre article : </label><br /><br /> <!-- Label relié au champs textarea par le for de label et le name de input-->
            <textarea name="contenuArticle" placeholder="La description" rows="10" cols="50"></textarea><br /><br /> <!-- name = description pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <input type="submit" name="ecrireArticle" value="Envoyer" /> <!-- name = ecrire pour pouvoir envoyer la methode $_POST -->
        </form>

    </div>

    <div id="postTheme">
        <h3> possibilité de poster des themes : </h3><br />

        <form method="POST">
            <label for="titreTheme"> Le titre de votre theme : </label> <!-- Label relié au champs input par le for de label et le name de input-->
            <input type="text" name="titreTheme" placeholder="Le titre" /><br><br /> <!-- name = titre pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->

            <label for="descriptionTheme"> description de votre article : </label><br /><br /> <!-- Label relié au champs textarea par le for de label et le name de input-->
            <textarea name="descriptionTheme" placeholder="La description" rows="10" cols="50"></textarea><br /><br /> <!-- name = description pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <input type="submit" name="ecrireTheme" value="Envoyer" /> <!-- name = ecrire pour pouvoir envoyer la methode $_POST -->
        </form>
    </div>

    <div id="postLangue">
        <h3> possibilité de poster des langues : </h3><br />


        <form method="POST">
            <label for="titleLangue"> La langue : </label> <!-- Label relié au champs input par le for de label et le name de input-->
            <input type="text" name="titleLangue" placeholder="Le titre de la langue" /><br><br /> <!-- name = titre pour pouvoir le récupérer avec $_POST grâce à la méthode employée par le formulaire -->
            <input type="submit" name="ecrireLangue" value="Envoyer" /> <!-- name = ecrire pour pouvoir envoyer la methode $_POST -->
        </form>

    </div>

    <?php
    include_once 'inc/footer.php';
    ?>

    <script src="scripts/toggle.js"></script>

</body>

</html>