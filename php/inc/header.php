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
        <?php else : ?>
            <a href="connexion.php" class="button">
                Se connecter
            </a>
        <?php endif; ?>
    </div>
</nav>