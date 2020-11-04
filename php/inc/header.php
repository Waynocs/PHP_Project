<header>

    <h1 class="main-title">
        <a href="index.php">
            <?= $title ?>
        </a>
    </h1>

</header>
<nav>
    <div>
        <a href="index.php" class="button">
            Les news
        </a>
        <?php if ($auth->user()) : ?>
            <a href="compte.php" class="button">
                Mon compte
            </a>
            <a href="?deco" class="button">
                Deconnexion
            </a>
        <?php else : ?>
            <a href="connexion.php" class="button">
                Se connecter
            </a>
        <?php endif; ?>
        <a href="changeDarkTheme.php?url=<?= urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?><?php
                                                                                                            if (!isset($_COOKIE["dark_theme"]))
                                                                                                                echo "&dark_theme=";
                                                                                                            ?>" class="button">
            Mode <?= isset($_COOKIE["dark_theme"]) ? "clair" : "sombre" ?>
        </a>
    </div>
</nav>