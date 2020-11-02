<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$session = new Session();

$auth = App::getAuth(); //récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD


$reqLangues = $bdd->query('SELECT * FROM langue');
$reqNews = $bdd->query('SELECT * FROM news ORDER BY date_news desc');

if (isset($_POST["langue"]))
    if (!empty($_POST['langueArticle'])) {
        $id_langue = htmlentities($_POST['langueArticle']);
        if ($id_langue != 0)
            $reqNews = $bdd->query('SELECT * FROM news WHERE id_langue = ? ORDER BY date_news desc', [$id_langue]);
    }
?>

<html lang="fr">

<head>
    <style>
        :root {
            --main-color: <?= "orange" ?>;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>
        Accueil | News
    </title>

</head>

<body>
    <header>

        <h1 class="main-title">
            <a href="index.php">
                News
            </a>
        </h1>

    </header>

    <nav>
        <div>
            <?php if ($auth->user()) : ?>
                <a href="compte.php" class="button">
                    Mon compte
                </a>
            <?php else : ?>
                <a href="connexion.php" class="button">
                    Se connecter
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <?php
    if ($session->read('flash')) {
        echo $session->read('flash');
        $session->delete('flash');
    }
    ?>

    <br />
    <h2>
        Visualisation de tous les news :
    </h2>

    <form method="POST">
        <label for="langueArticle">
            Trier par langue :
        </label>
        <select name="langueArticle">
            <option value="0" <?php if (!isset($_POST['langueArticle'])) : ?> selected <?php endif; ?>>
                TOUTES LES LANGUES
            </option>

            <?php foreach ($reqLangues as $reqLangue) : ?>
                <option <?php if (isset($_POST['langueArticle']) && $_POST['langueArticle'] == $reqLangue->id_langue) : ?> selected <?php endif ?> value="<?= $reqLangue->id_langue ?>">
                    <?= $reqLangue->title ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="langue">
    </form>

    <?php  //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)

    if ($reqNews->rowCount()) : //On regarde si il y'a des articles 
    ?>
        <div id="articles">
            <?php
            foreach ($reqNews as $reqNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
                $reqTheme = $bdd->query("SELECT * FROM theme WHERE id_theme=?", [$reqNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
                $reqLangue = $bdd->query("SELECT * FROM langue WHERE id_langue=?", [$reqNew->id_langue])->fetch();
                $reqEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqNew->id_editor])->fetch();
            ?>


                <div class="article">
                    <!-- < ?= signifie : < ?php echo -->
                    <p>
                        <strong>
                            <u>
                                L'auteur
                            </u>
                            :
                        </strong>
                        <?= $reqEditor->surname, " ", $reqEditor->name; ?>
                        <?php if ($auth->user()) : ?>
                            <a href="mailto: <?= $reqEditor->mail_address; ?>">
                                <?= $reqEditor->mail_address; ?>
                            </a>
                        <?php endif; ?>
                    </p>
                    <br /><!-- affiche le mail si connecté en plus de nom + prénom, sinon non-->
                    <p>
                        <strong>
                            <u>
                                La langue
                            </u>
                            :
                        </strong>
                        <?= $reqLangue->title; ?>
                    </p>
                    <br />
                    <p>
                        <strong>
                            <u>
                                Le titre
                            </u>
                            :
                        </strong>
                        <?= $reqNew->title_news; ?>
                    </p>
                    <br /><!-- On affiche par un echo le titre de l'index reqNew-->
                    <p title="Description : <?= $reqTheme->description; ?>">
                        <strong>
                            <u>
                                Le theme
                            </u>
                            :
                        </strong>
                        <?= $reqTheme->title ?>
                    </p>
                    <br /><!-- On affiche par un echo le theme de l'index reqNew-->
                    <p>
                        <strong>
                            <u>
                                Le contenu
                            </u>
                            :
                        </strong>
                        <?= $reqNew->text_news; ?>
                    </p>
                    <br /><!-- On affiche par un echo le contenu de l'index reqNew-->
                    <p>
                        <strong>
                            <u>
                                La date
                            </u>
                            :
                        </strong>
                        <?= date("d/m/y H:i:s", strtotime($reqNew->date_news)); ?>
                    </p>
                    <br /> <!-- On affiche par un echo la date de l'index reqNew -->
                </div>

            <?php
            endforeach; //close foreach
            ?>
        </div>
    <?php
    else :
    ?>
        <p>
            Aucune news enregistrées dans la base de donnée
        </p> <!-- Dans le cas où il n'y a pas d'article -->
    <?php endif; ?>

    <?php
    include_once 'inc/footer.php';
    ?>

</body>

</html>