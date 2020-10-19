<?php
if (!defined('connection')) {
    define('connection', '');
    try {
        $objPdo = new PDO("mysql:host=localhost;port=3306;dbname=projet_php", "root", "");
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}
