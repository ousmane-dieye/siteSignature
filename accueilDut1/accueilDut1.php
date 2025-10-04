<?php
session_start();
require '../db.php';

// Vérifier si le user est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexionDut1/connexionDut1.php");
    exit();
}

// Récupérer informations du DUT1 connecté
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM dut1 WHERE id = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    echo "Utilisateur non trouvé";
    exit();
}

// Récupérer le nombre de signatures
$stmt = $pdo->prepare("SELECT COUNT(*) as signature_count FROM signature WHERE id_dut1 = ?");
$stmt->execute([$user_id]);
$signatureData = $stmt->fetch(PDO::FETCH_ASSOC);
$signatureCount = $signatureData['signature_count'];

// Récupérer le classement de tous les DUT1
$rankingStmt = $pdo->prepare("
    SELECT d.id, d.prenom, d.nom, COUNT(s.id_Mame) as nb_signatures
    FROM dut1 d
    LEFT JOIN signature s ON d.id = s.id_dut1
    GROUP BY d.id
    ORDER BY nb_signatures DESC, d.nom ASC
");
$rankingStmt->execute();
$allRankings = $rankingStmt->fetchAll(PDO::FETCH_ASSOC);

// Trouver le rang de l'utilisateur
$userRank = 0;
foreach ($allRankings as $index => $user) {
    if ($user['id'] == $user_id) {
        $userRank = $index + 1;
        break;
    }
}

// Récupérer la liste des utilisateurs valides
$validUsersStmt = $pdo->prepare("SELECT username FROM parrainmarrainemame");
$validUsersStmt->execute();
$validUsers = $validUsersStmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les signatures déjà reçues
$receivedStmt = $pdo->prepare("
    SELECT pm.username 
    FROM signature s 
    JOIN parrainmarrainemame pm ON s.id_Mame = pm.id 
    WHERE s.id_dut1 = ?
");
$receivedStmt->execute([$user_id]);
$receivedSignatures = $receivedStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil DUT1 - Signature</title>
    <link rel="stylesheet" href="accueilDut1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Bouton toggle dark/light mode -->
    <button class="theme-toggle" id="theme-toggle" title="Changer le thème">
        <i class="fas fa-moon"></i>
    </button>

    <div class="container">
        <header class="header">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="<?php echo htmlspecialchars($userData['photo'] ?? 'https://via.placeholder.com/150'); ?>" alt="Photo de l'utilisateur" id="user-photo">
                </div>
                <div class="user-text">
                    <h2>Heureux de vous revoir,</h2>
                    <h1 id="user-name"><?php echo htmlspecialchars($userData['prenom'] . ' ' . $userData['nom']); ?></h1>
                </div>
            </div>
            <a href="deconnexion.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>
        </header>

        <div class="main-content">
            <div class="content-card">
                <div class="card-header">
                    <h2>TABLEAU DE BORD SIGNATURES</h2>
                    <p>Gérez vos signatures et suivez votre classement</p>
                </div>

                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-number" id="signature-count"><?php echo $signatureCount; ?></div>
                        <div class="stat-label">Signatures reçues</div>
                    </div>
                    
                    <div class="ranking-card">
                        <h3>CLASSEMENT</h3>
                        <div class="ranking-number">#<?php echo $userRank; ?></div>
                        <div class="ranking-label">sur <?php echo count($allRankings); ?> DUT1</div>
                        
                        <?php if ($userRank <= 5): ?>
                            <div class="ranking-message">
                                <?php if ($userRank == 1): ?>
                                    <div class="medal gold">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h4>Félicitations, vous êtes premier !</h4>
                                    <p>Continuez à dominer vos promos et à prendre le plus de signatures possibles</p>
                                <?php elseif ($userRank == 2): ?>
                                    <div class="medal silver">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                    <h4>Félicitations, vous êtes deuxième !</h4>
                                    <p>Vous êtes sur le podium, continuez vos efforts !</p>
                                <?php elseif ($userRank == 3): ?>
                                    <div class="medal bronze">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                    <h4>Félicitations, vous êtes troisième !</h4>
                                    <p>Belle performance, gardez cette position !</p>
                                <?php else: ?>
                                    <div class="ranking-encouragement">
                                        <i class="fas fa-star"></i>
                                        <h4>Félicitations, vous êtes <?php echo $userRank; ?>ème</h4>
                                        <p>Continuez, vous y êtes presque !</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="user-info-card">
                    <h3>INFORMATIONS PERSONNELLES</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nom d'utilisateur</span>
                            <span class="info-value" id="username"><?php echo htmlspecialchars($userData['username']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Téléphone</span>
                            <span class="info-value" id="phone"><?php echo htmlspecialchars($userData['telephone']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="actions-section">
                    <button class="btn-primary" id="get-signature-btn">
                        <i class="fas fa-signature"></i>
                        SE FAIRE SIGNER
                    </button>
                    <a href="signatures.php" class="btn-secondary">
                        <i class="fas fa-list"></i>
                        VOIR MES SIGNATURES
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="signature-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>OBTENIR UNE SIGNATURE</h2>
                <span class="close-modal" id="close-modal">&times;</span>
            </div>
            <p>Veuillez entrer les informations du DUT2 ou Mame</p>
            
            <form method="POST" action="traiter_signature.php" id="signature-form">
                <div class="form-group">
                    <label for="username-input">Nom d'utilisateur</label>
                    <input type="text" id="username-input" name="username" placeholder="Ex: Jerry" required>
                </div>
                
                <div class="form-group">
                    <label for="phone-input">Numéro de téléphone</label>
                    <input type="tel" id="phone-input" name="telephone" placeholder="Ex: +221 77 777 77 77" required>
                </div>
                
                <div class="error-message" id="username-error">Informations invalides</div>
                
                <button type="submit" class="btn-primary" id="submit-signature">VALIDER</button>
            </form>
            
            <div class="success-message" id="success-message">Signature enregistrée avec succès!</div>
        </div>
    </div>

    <script>
        const validUsers = <?php echo json_encode($validUsers); ?>;
        const receivedSignatures = <?php echo json_encode($receivedSignatures); ?>;
    </script>
    <script src="accueilDut1.js"></script>
</body>
</html>