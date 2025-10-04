<?php
session_start();
require '../db.php';

// Vérifier si le user est online
if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexionDut1/connexionDut1.php");
    exit();
}

// Récupérer les infos du dayte1
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM dut1 WHERE id = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    echo "Utilisateur non trouvé";
    exit();
}

// Récupérer les signatures avec les infos des mames ak dayte2
$stmt = $pdo->prepare("
    SELECT 
        pm.nom,
        pm.prenom,
        pm.username,
        pm.telephone,
        pm.niveau,
        s.id_Mame
    FROM signature s
    JOIN parrainmarrainemame pm ON s.id_Mame = pm.id
    WHERE s.id_dut1 = ?
    ORDER BY pm.niveau, pm.nom
");
$stmt->execute([$user_id]);
$signatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nombre total de signatures
$countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM signature WHERE id_dut1 = ?");
$countStmt->execute([$user_id]);
$totalSignatures = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Signatures - DUT1</title>
    <link rel="stylesheet" href="signatures.css">
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
                    <img src="<?php echo htmlspecialchars($userData['photo'] ?? 'https://via.placeholder.com/150'); ?>" alt="Photo de l'utilisateur">
                </div>
                <div class="user-text">
                    <h2>Mes signatures reçues</h2>
                    <h1><?php echo htmlspecialchars($userData['prenom'] . ' ' . $userData['nom']); ?></h1>
                </div>
            </div>
        </header>

        <div class="main-content">
            <div class="content-card">
                <div class="card-header">
                    <h2>LISTE DES SIGNATURES</h2>
                    <p>Vous avez reçu <?php echo $totalSignatures; ?> signature(s)</p>
                </div>

                <?php if (empty($signatures)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Aucune signature reçue</h3>
                        <p>Utilisez le bouton "Se faire signer" pour obtenir vos premières signatures</p>
                    </div>
                <?php else: ?>
                    <div class="signatures-list">
                        <?php foreach ($signatures as $signature): ?>
                            <div class="signature-item">
                                <div class="signature-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="signature-details">
                                    <h3><?php echo htmlspecialchars($signature['prenom'] . ' ' . $signature['nom']); ?></h3>
                                    <div class="signature-info">
                                        <span class="info-label">Niveau:</span>
                                        <span class="info-value"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $signature['niveau']))); ?></span>
                                    </div>
                                    <div class="signature-info">
                                        <span class="info-label">Nom d'utilisateur:</span>
                                        <span class="info-value">@<?php echo htmlspecialchars($signature['username']); ?></span>
                                    </div>
                                    <div class="signature-info">
                                        <span class="info-label">Téléphone:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($signature['telephone']); ?></span>
                                    </div>
                                </div>
                                <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', $signature['telephone'])); ?>" 
                                   target="_blank" 
                                   class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                    WhatsApp
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="actions-section">
                    <a href="accueilDut1.php" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        RETOUR À L'ACCUEIL
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestion du thème pour signatures
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-toggle').querySelector('i');
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                document.getElementById('theme-toggle').title = 'Passer en mode clair';
            } else {
                icon.className = 'fas fa-moon';
                document.getElementById('theme-toggle').title = 'Passer en mode sombre';
            }
        }

        document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
        document.addEventListener('DOMContentLoaded', initTheme);
    </script>
</body>
</html>
