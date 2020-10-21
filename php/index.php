<?php
include 'class/App.php';
include 'class/Auth.php';
include 'class/Session.php';
include 'class/Database.php';

$auth = App::getAuth(); //récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD

?>

<html lang=\"fr\">

<head>
    <link type="text/css" rel="stylesheet" href="../css/index.css">
    <meta charset=\"UTF-8\" />
    <title> Accueil | News </title>

</head>

<body>
    <header>

        <h1> <a href="index.php"> Divers nouvelles</a> </h1>

    </header>

    <nav>
        <p><?php if ($auth->user()) : ?><button class="buttoncompte"><a href="compte.php">Mon compte</a></button> <?php else : ?><button class="moncompte"><a href="connexion.php">Se connecter</a></button><?php endif; ?></p>
    </nav>
    <h2> Visualisation de tous les news : </h2>

    <?php
    $reqNews = $bdd->query('SELECT * FROM news ORDER BY date_news desc');  //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)

    if ($reqNews->rowCount()) : //On regarde si il y'a des articles
        foreach ($reqNews as $reqNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
            $reqTheme = $bdd->query("SELECT description FROM theme WHERE id_theme=?", [$reqNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
            $reqEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqNew->id_editor])->fetch();
    ?>
            <!-- < ?= signifie : < ?php echo -->
            <p> L'auteur : <?= $reqEditor->surname, " ", $reqEditor->name; ?> <?php if ($auth->user()) : ?> <a href="mailto: <?= $reqEditor->mail_address; ?>"><?= $reqEditor->mail_address; ?></a> <?php endif; ?> </p> <!-- affiche le mail si connecté en plus de nom + prénom, sinon non-->
            <p> Le titre : <?= $reqNew->title_news; ?> </p> <!-- On affiche par un echo le titre de l'index reqNew-->
            <p> Le theme : <?= $reqTheme->description ?> </p> <!-- On affiche par un echo le theme de l'index reqNew-->
            <p> Le contenu : <?= $reqNew->text_news; ?> </p> <!-- On affiche par un echo le contenu de l'index reqNew-->
            <p> La date : <?= date("d/m/y H:i:s", strtotime($reqNew->date_news)); ?> </p><br /> <!-- On affiche par un echo la date de l'index reqNew -->
        <?php
        endforeach; //close foreach
    else :
        ?>
        <p> Aucune news enregistrées dans la base de donnée </p> <!-- Dans le cas où il n'y a pas d'article -->
    <?php endif; ?>
</body>

</html>