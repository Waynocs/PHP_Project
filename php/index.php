<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';
include_once './inc/utils.php';

include("./inc/base.php");

$reqThemes = $bdd->query('SELECT * FROM theme');
$reqLangues = $bdd->query('SELECT * FROM langue');
$reqNews = $bdd->query('SELECT * FROM news WHERE visibility ORDER BY date_news desc');

if (isset($_POST["langue"]))
    if (!empty($_POST['langueArticle'])) {
        $id_langue = htmlspecialchars($_POST['langueArticle']);
        if ($id_langue != 0)
            $reqNews = $bdd->query('SELECT * FROM news WHERE id_langue = ? AND visibility ORDER BY date_news desc', [$id_langue]);
    }
?>

<?php
if (isset($_POST["theme"]))

    if (!empty($_POST['themeArticle'])) {
        $id_theme = htmlspecialchars($_POST['themeArticle']);
        if ($id_theme != 0)
            $reqNews = $bdd->query('SELECT * FROM news WHERE id_theme = ? AND visibility ORDER BY date_news desc', [$id_theme]);
    }
?>

<html lang="fr">

<head>
    <style>
        <?php
        include("./inc/style.php");
        foreach ($bdd->query('SELECT * FROM theme') as $theme) {
            $color = $theme->color;
            if (darkTheme())
                $color = getDarkThemeColor($color, "ffffff", "303030");
            echo ".theme-" . $theme->id_theme . " {\n";
            echo "border: solid 1px #$color;\n";
            echo "transition: background-color .2s;\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ":hover {\n";
            echo "background-color: #$color" . 10 . ";\n";
            echo "transition: background-color .2s;\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ":hover {\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ">a {\n";
            echo "border-bottom: solid 1px #$color;\n";
            echo "transition: background-color .2s, color .2s;\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ">a:hover {\n";
            echo "background-color: #$color;\n";
            echo "transition: background-color .2s, color .2s;\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ">a>h3 {\n";
            echo "text-align: center;\n";
            echo "color: #$color;\n";
            echo "transition: letter-spacing .2s;\n";
            echo "}\n";
            echo ".theme-" . $theme->id_theme . ">a:hover>h3 {\n";
            echo "color: var(--themed-white);\n";
            echo "letter-spacing: .15rem;\n";
            echo "transition: letter-spacing .2s;\n";
            echo "}\n";
        }
        ?>
    </style>
    <link type="text/css" rel="stylesheet" href="../css/style.css">
    <link type="text/css" rel="stylesheet" href="../css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>
        Accueil | News
    </title>

</head>

<body>
    <?php
    $title = "News";
    include("./inc/header.php");
    ?>
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


                    <div class="article <?= "theme-" . $reqTheme->id_theme ?>">
                        <a href="detailArticle.php?id_news=<?= $reqNew->id_news; ?> ">
                            <!-- TODO lien vers l'article complet -->
                            <h3>
                                <?= $reqNew->title_news; ?>
                            </h3>
                        </a>
                        <div>
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
                                        Le theme
                                    </u>
                                    :
                                </strong>
                                <span title="Description : <?= $reqTheme->description; ?>">
                                    <?= $reqTheme->title ?>
                                </span>
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
        if ($auth->user()) :

        ?>

            <h2>
                Visualisation de tous mes news :
            </h2>
            <hr />

            <?php  //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
            $id_editor = $_SESSION["auth"]->id_editor;
            $reqMyNews = $bdd->query('SELECT * FROM news WHERE id_editor = ? ORDER BY date_news desc', [$id_editor]);
            if ($reqMyNews->rowCount()) : //On regarde si il y'a des articles 
            ?>
                <div id="own-articles">
                    <?php
                    foreach ($reqMyNews as $reqMyNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
                        $reqMyTheme = $bdd->query("SELECT * FROM theme WHERE id_theme=?", [$reqMyNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
                        $reqMyLangue = $bdd->query("SELECT * FROM langue WHERE id_langue=?", [$reqMyNew->id_langue])->fetch();
                        $reqMyEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqMyNew->id_editor])->fetch();
                    ?>


                        <div class="article <?= "theme-" . $reqMyTheme->id_theme ?>">
                            <a href="detailArticle.php?id_news=<?= $reqMyNew->id_news; ?> ">
                                <h3>
                                    <?= $reqMyNew->title_news; ?>
                                </h3>
                            </a>
                            <div>
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
                                            La date
                                        </u>
                                        :
                                    </strong>
                                    <?= date("d/m/y H:i:s", strtotime($reqMyNew->date_news)); ?>
                                </p>

                                <a href="removeArticle.php?id_news=<?= $reqMyNew->id_news; ?> "> <button class="warning button">Supprimer</button></a>
                                <a href="changeVisibility.php?id_news=<?= $reqMyNew->id_news; ?>&visibility=<?= $reqMyNew->visibility; ?> "> <button class="info button"><?php if ($reqMyNew->visibility) : ?> Passer en privé <?php else : ?>Passer en public<?php endif; ?></button></a>

                            </div>
                        </div>
                    <?php
                    endforeach; //close foreach
                    ?>
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