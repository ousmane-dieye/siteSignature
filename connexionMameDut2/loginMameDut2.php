<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM parrainmarrainemame WHERE Username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = 'parrainmarrainemame'; // ou $user['role'] si stocké dans la table
        header("Location: dut1_dashboard.php"); // redirection selon rôle
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
