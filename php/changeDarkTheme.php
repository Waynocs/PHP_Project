<?php
if (isset($_GET["dark_theme"]))
    setcookie("dark_theme", "enabled", time() + 3600 * 24 * 30, '/');
else {
    unset($_COOKIE['dark_theme']);
    setcookie('dark_theme', null, -1, '/');
}
if (isset($_GET["url"])) {
    header("Location:" . urldecode($_GET["url"]));
    die();
}
