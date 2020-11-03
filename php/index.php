<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';

$session = new Session();

$auth = App::getAuth(); //récupération de l'Auth
$bdd = App::getDatabase(); //récupération de la BdD

$reqThemes = $bdd->query('SELECT * FROM theme');
$reqLangues = $bdd->query('SELECT * FROM langue');
$reqNews = $bdd->query('SELECT * FROM news WHERE visibility ORDER BY date_news desc');

if (isset($_POST["langue"]))
    if (!empty($_POST['langueArticle'])) {
        $id_langue = htmlentities($_POST['langueArticle']);
        if ($id_langue != 0)
            $reqNews = $bdd->query('SELECT * FROM news WHERE id_langue = ? AND visibility ORDER BY date_news desc', [$id_langue]);
    }
?>

<?php
if (isset($_POST["theme"]))

    if (!empty($_POST['themeArticle'])) {
        $id_theme = htmlentities($_POST['themeArticle']);
        var_dump($id_theme);
        if ($id_theme != 0)
            $reqNews = $bdd->query('SELECT * FROM news WHERE id_theme = ? AND visibility ORDER BY date_news desc', [$id_theme]);
    }
?>

<html lang="fr">

<head>
    <style>
        :root {
            --main-color: <?= "orange" ?>;
            --main-white: <?= "white" ?>;
            --main-black: <?= "black" ?>;
            --main-light: <?= "white" ?>;
            --main-dark: <?= "#181818" ?>;
            --themed-color: <?= "orange" /* todo */ ?>;
            --themed-white: <?= "white" /* todo */ ?>;
            --themed-black: <?= "black" /* todo */ ?>;
            --themed-light: <?= "white" /* todo */ ?>;
            --themed-dark: <?= "black" /* todo */ ?>;
            --accent-color: <?= "blue" /* todo */ ?>;
            --validate-color: <?= "green" /* todo */ ?>;
            --cancel-color: <?= "red" /* todo */ ?>;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="../css/index.css">
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
    <main>
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
                Filtrer par langue :
            </label>
            <select name="langueArticle" class="button">
                <option value="0" <?php if (!isset($_POST['langueArticle'])) : ?> selected <?php endif; ?>>
                    TOUTES LES LANGUES
                </option>

                <?php foreach ($reqLangues as $reqLangue) : ?>
                    <option <?php if (isset($_POST['langueArticle']) && $_POST['langueArticle'] == $reqLangue->id_langue) : ?> selected <?php endif ?> value="<?= $reqLangue->id_langue ?>">
                        <?= $reqLangue->title ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input class="info button" type="submit" name="langue" value="Filtrer" />
        </form>
        <div id="or">
            <p>OU</p>
        </div>

        <form method="POST">
            <label for="themeArticle">
                Filtrer par thème :
            </label>
            <select name="themeArticle" class="button">
                <option value="0" <?php if (!isset($_POST['themeArticle'])) : ?> selected <?php endif; ?>>
                    TOUS LES THEMES
                </option>

                <?php foreach ($reqThemes as $reqTheme) : ?>
                    <option <?php if (isset($_POST['themeArticle']) && $_POST['themeArticle'] == $reqTheme->id_theme) : ?> selected <?php endif ?> value="<?= $reqTheme->id_theme ?>">
                        <?= $reqTheme->title ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input class="info button" type="submit" name="theme" value="Filtrer" />
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


                    <div class="article" style="border-color: <?= "blue" /* couleur du thème de l'article */ ?>;">
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

                        <p>
                            <strong>
                                <u>
                                    La langue
                                </u>
                                :
                            </strong>
                            <?= $reqLangue->title; ?>
                        </p>

                        <p>
                            <strong>
                                <u>
                                    Le titre
                                </u>
                                :
                            </strong>
                            <?= $reqNew->title_news; ?>
                        </p>

                        <p title="Description : <?= $reqTheme->description; ?>">
                            <strong>
                                <u>
                                    Le theme
                                </u>
                                :
                            </strong>
                            <?= $reqTheme->title ?>
                        </p>

                        <p>
                            <strong>
                                <u>
                                    Le contenu
                                </u>
                                :
                            </strong>
                            <?= $reqNew->text_news; ?>
                        </p>

                        <p>
                            <strong>
                                <u>
                                    La date
                                </u>
                                :
                            </strong>
                            <?= date("d/m/y H:i:s", strtotime($reqNew->date_news)); ?>
                        </p>

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

<!-- ---------------------------------------------------------------------------------------- -->
<?php
if($auth->user()) :

?>


    <hr>

    <?php  //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
    $id_editor = $_SESSION["auth"]->id_editor;
    $reqMyNews = $bdd->query('SELECT * FROM news WHERE id_editor = ? ORDER BY date_news desc', [$id_editor]);
    if ($reqMyNews->rowCount()) : //On regarde si il y'a des articles 
    ?>
        <div id="articles">
            <?php
            foreach ($reqMyNews as $reqMyNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
                $reqMyTheme = $bdd->query("SELECT * FROM theme WHERE id_theme=?", [$reqMyNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
                $reqMyLangue = $bdd->query("SELECT * FROM langue WHERE id_langue=?", [$reqMyNew->id_langue])->fetch();
                $reqMyEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqMyNew->id_editor])->fetch();
            ?>


                <div class="article" style="border-color: <?= "blue" /* couleur du thème de l'article */ ?>;">
                    <!-- < ?= signifie : < ?php echo -->
                    <p>
                        <strong>
                            <u>
                                L'auteur
                            </u>
                            :
                        </strong>
                        <?= $reqMyEditor->surname, " ", $reqMyEditor->name; ?>
                        <?php if ($auth->user()) : ?>
                            <a href="mailto: <?= $reqMyEditor->mail_address; ?>">
                                <?= $reqMyEditor->mail_address; ?>
                            </a>
                        <?php endif; ?>
                    </p>

                    <p>
                        <strong>
                            <u>
                                La langue
                            </u>
                            :
                        </strong>
                        <?= $reqMyLangue->title; ?>
                    </p>

                    <p>
                        <strong>
                            <u>
                                Le titre
                            </u>
                            :
                        </strong>
                        <?= $reqMyNew->title_news; ?>
                    </p>

                    <p title="Description : <?= $reqMyTheme->description; ?>">
                        <strong>
                            <u>
                                Le theme
                            </u>
                            :
                        </strong>
                        <?= $reqMyTheme->title ?>
                    </p>

                    <p>
                        <strong>
                            <u>
                                Le contenu
                            </u>
                            :
                        </strong>
                        <?= $reqMyNew->text_news; ?>
                    </p>

                    <p>
                        <strong>
                            <u>
                                La date
                            </u>
                            :
                        </strong>
                        <?= date("d/m/y H:i:s", strtotime($reqMyNew->date_news)); ?>
                    </p> 

                        <a href="removeArticle.php?id_news=<?= $reqMyNew->id_news; ?> "> <button class="warning button">Supprimer</button></a>
                        <a href="changeVisibility.php?id_news=<?= $reqMyNew->id_news; ?>&visibility=<?= $reqMyNew->visibility; ?> "> <button class="info button"><?php if($reqMyNew->visibility) : ?> Passer en privé <?php else : ?>Passer en public<?php endif; ?></button></a> 

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
<?php endif; ?>



    </main>
    <?php
    include_once 'inc/footer.php';
    ?>

</body>

</html>