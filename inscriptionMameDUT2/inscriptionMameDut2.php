<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $telephone = $_POST['telephone'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['niveau']; 
  #  $photo = $_POST['photo'];

    $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    try {

        $stmt = $pdo->prepare(
            "INSERT INTO parrainmarrainemame (nom, prenom, username, telephone, `mot_de_passe`, niveau) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nom, $prenom, $username, $telephone, $hash, $role]);

        echo "Utilisateur ajouté avec succès !";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Erreur : Nom d'utilisateur ou téléphone déjà utilisé !";
        } else {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>
