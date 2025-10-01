<?php
$host = "127.0.0.1";        // Adresse du serveur MySQL (localhost)
$dbname = "sitesignature";  // Nom de la base de données
$user = "root";             // Nom d’utilisateur MySQL
$pass = "";                 // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion reusie";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
