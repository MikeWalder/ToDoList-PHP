<?php
//connexion à notre base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=force3;port=3308;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "connexion established<br>";

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
