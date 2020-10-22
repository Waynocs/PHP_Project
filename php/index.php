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
    <link type="text/css" rel="stylesheet" href="../css/commun.css">
    <link type="text/css" rel="stylesheet" href="../css/index.css">
    <meta charset=\"UTF-8\" />
    <title> Accueil | News </title>

</head>

<body>
    <header>

        <h1> <a href="index.php"> Divers nouvelles</a> </h1>

    </header>

    <nav>
        <p><?php if ($auth->user()) : ?><a href="compte.php"><button>Mon compte</button> </a><?php else : ?><a href="connexion.php"><button>Se connecter</button></a><?php endif; ?></p>
    </nav>
    <br />
    <h2> Visualisation de tous les news : </h2>


    <?php
    $reqNews = $bdd->query('SELECT * FROM news ORDER BY date_news desc');  //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)

    if ($reqNews->rowCount()) : //On regarde si il y'a des articles 
    ?>
        <div id="articles">
            <?php
            foreach ($reqNews as $reqNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
                $reqTheme = $bdd->query("SELECT description FROM theme WHERE id_theme=?", [$reqNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
                $reqEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqNew->id_editor])->fetch();
            ?>


                <div class="article">
                    <!-- < ?= signifie : < ?php echo -->
                    <p> <strong>L'auteur : </strong><?= $reqEditor->surname, " ", $reqEditor->name; ?> <?php if ($auth->user()) : ?> <a href="mailto: <?= $reqEditor->mail_address; ?>"><?= $reqEditor->mail_address; ?></a> <?php endif; ?> </p> <br /><!-- affiche le mail si connecté en plus de nom + prénom, sinon non-->
                    <p> <strong>Le titre : </strong><?= $reqNew->title_news; ?> </p> <br /><!-- On affiche par un echo le titre de l'index reqNew-->
                    <p> <strong>Le theme : </strong><?= $reqTheme->description ?> </p> <br /><!-- On affiche par un echo le theme de l'index reqNew-->
                    <p> <strong>Le contenu : </strong><?= $reqNew->text_news; ?> </p> <br /><!-- On affiche par un echo le contenu de l'index reqNew-->
                    <p> <strong>La date : </strong><?= date("d/m/y H:i:s", strtotime($reqNew->date_news)); ?> </p><br /> <!-- On affiche par un echo la date de l'index reqNew -->
                </div>

            <?php
            endforeach; //close foreach
            ?>
        </div>
    <?php
    else :
    ?>
        <p> Aucune news enregistrées dans la base de donnée </p> <!-- Dans le cas où il n'y a pas d'article -->
    <?php endif; ?>

    <?php
    include 'inc/footer.php';
    ?>