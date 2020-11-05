<?php
include_once 'class/App.php';
include_once 'class/Auth.php';
include_once 'class/Session.php';
include_once 'class/Database.php';
include_once './inc/utils.php';

include_once("./inc/base.php");


if (!isset($_GET['id_news']) || empty($_GET['id_news']) || !is_numeric($_GET['id_news'])) {
    header('location: index.php');
    die();
}
$id_news = htmlspecialchars($_GET['id_news']);
$reqNews = $bdd->query('SELECT * FROM news WHERE (visibility OR id_editor = ' . ($auth->user() ? $auth->user()->id_editor : -1) . ') AND id_news=?', [$id_news]);
if (!$reqNews->rowCount()) {
    header("location: index.php");
    die();
}
$reqNew = $reqNews->fetch();
$reqTheme = $bdd->query("SELECT * FROM theme WHERE id_theme=?", [$reqNew->id_theme])->fetch(); //variable prenant la BdD et appel la fonction query (de la class DataBase pour pouvour sélécionner tous les attributs de la table new)
$reqLangue = $bdd->query("SELECT * FROM langue WHERE id_langue=?", [$reqNew->id_langue])->fetch();
$reqEditor = $bdd->query("SELECT surname, name, mail_address FROM editor WHERE id_editor=?", [$reqNew->id_editor])->fetch();


?>







<html>

<head>
    <style>
        <?php
        include_once("./inc/style.php");
        $color = $reqTheme->color;
        if (darkTheme())
            $color = getDarkThemeColor($color, "ffffff", "303030");
        ?> :root {
            --themed-color: <?= "#$color" ?>;
        }

        <?php
        foreach ($bdd->query('SELECT * FROM theme') as $theme) {
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
    <link type="text/css" rel="stylesheet" href="../css/detailArticle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title> <?= $reqNew->title_news; ?> </title>
</head>

<body>
    <?php
    $title = "News";
    include_once("./inc/header.php");
    ?>
    <div class="band"></div>
    <main>
        <span class="infobar" title="Description : <?= $reqTheme->description; ?>">
            <?= $reqTheme->title ?>
        </span>
        <h3 class="big title">
            <?= $reqNew->title_news; ?>
        </h3>
        <div class="infos">
            <?= $reqLangue->title; ?> -
            <?= $reqEditor->surname, " ", $reqEditor->name; ?>
            <?php if ($auth->user()) : ?>
                <a href=" mailto: <?= $reqEditor->mail_address; ?>">
                    <?= $reqEditor->mail_address; ?>
                </a>
            <?php endif; ?> - <?= date("d/m/y H:i:s", strtotime($reqNew->date_news)); ?>
        </div>
        <?= formatText($reqNew->text_news); ?>
        <div class="space"></div>
        <a href="index.php"><button class="button">Retour</button></a>
    </main>
    <?php
    include_once 'inc/footer.php';
    ?>
</body>

</html>