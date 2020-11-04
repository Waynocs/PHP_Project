<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';
include_once './inc/utils.php';

include("./inc/base.php");


if (!isset($_GET['id_news']) || empty($_GET['id_news']) || !is_numeric($_GET['id_news'])) {
    header('location: index.php');
    exit();
}
$id_news = htmlentities($_GET['id_news']);
$reqNews = $bdd->query('SELECT * FROM news WHERE visibility AND id_news=?', [$id_news]);

if (!$reqNews->rowCount()) {
    header("location: index.php");
    exit();
}

?>







<html>

<head>
    <style>
        <?php
        include("./inc/style.php");
        foreach ($bdd->query('SELECT * FROM theme') as $theme) {
            $color = $theme->color;
            if (darkTheme())
                $color = getDarkThemeColor($color, "ffffff", "000000");
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
    <title> <?= $reqNew->$title_news; ?> </title>
</head>

<body>
    <?php
    $title = "News";
    include("./inc/header.php");
    ?>
    <div id="articles">
        <?php
        foreach ($reqNews as $reqNew) :  //On créé une variable clef reqNew servant d'index pour pouvoir afficher le contenu de la BdD new grâce au foreach
            $reqTheme = $bdd->query("SELECT * FROM theme WHERE id_theme=?", [$reqNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
            $reqLangue = $bdd->query("SELECT * FROM langue WHERE id_langue=?", [$reqNew->id_langue])->fetch();
            $reqEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqNew->id_editor])->fetch();
        ?>


            <div class="article <?= "theme-" . $reqTheme->id_theme ?>">

                <h3>
                    <?= $reqNew->title_news; ?>
                </h3>

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
                            <a href=" mailto: <?= $reqEditor->mail_address; ?>">
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

            </div>

        <?php
        endforeach; //close foreach
        ?>
    </div>

    <a href="index.php"><button class="button">Retour</button></a>
</body>

</html>