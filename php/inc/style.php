<?php
include_once 'inc/utils.php';

$darkMode = isset($_COOKIE["dark_theme"]);
?>
:root {
--main-color: <?= "orange" ?>;
--main-white: <?= "white" ?>;
--main-black: <?= "black" ?>;
--main-light: <?= "white" ?>;
--main-dark: <?= "#181818" ?>;
--themed-color: <?= $darkMode ? "#" . getDarkThemeColor("ffa500", "ffffff", "303030") : "#ffa500" ?>;
--themed-white: <?= $darkMode ? "black" : "white" ?>;
--themed-black: <?= $darkMode ? "white" : "black" ?>;
--themed-light: <?= $darkMode ? "#303030" : "white" ?>;
--themed-dark: <?= $darkMode ? "#d0d0d0" : "black"  ?>;
--validate-color: <?= $darkMode ? "#" . getDarkThemeColor("1ED760", "ffffff", "303030") : "#1ED760" ?>;
--cancel-color: <?= $darkMode ? "#" . getDarkThemeColor("D2060D", "ffffff", "303030") : "#D2060D" ?>;
}