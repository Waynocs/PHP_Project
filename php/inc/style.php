<?php
$darkMode = isset($_COOKIE["dark_theme"]);
?>
:root {
--main-color: <?= "orange" ?>;
--main-white: <?= "white" ?>;
--main-black: <?= "black" ?>;
--main-light: <?= "white" ?>;
--main-dark: <?= "#181818" ?>;
--themed-color: <?= $darkMode ? "orange" : "orange" ?>;
--themed-white: <?= $darkMode ? "black" : "white" ?>;
--themed-black: <?= $darkMode ? "white" : "black" ?>;
--themed-light: <?= $darkMode ? "#303030" : "white" ?>;
--themed-dark: <?= $darkMode ? "#d0d0d0" : "black"  ?>;
--validate-color: <?= $darkMode ? "green" : "green" ?>;
--cancel-color: <?= $darkMode ? "red" : "red" ?>;
}