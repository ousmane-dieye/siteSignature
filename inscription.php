<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $telephone = $_POST['telephone'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm =$_POST['confirmer_mdp'];
    $role = $_POST['role']; 
    $photo = $_POST['photo'];

    $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    try {
        while ($confirm === $mot_de_passe){
            echo "les mots de passe sont different";
            break;
        }
        $stmt = $pdo->prepare(
            "INSERT INTO parrainmarrainemame (Nom, Prenom, Username, Telephone, `mot_de_passe`, Photo, niveau) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nom, $prenom, $username, $telephone, $hash, $photo, $role]);

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
