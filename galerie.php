<?php
// 1. Connexion à la base de données
$host = 'localhost';
$dbname = 'sodes_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 20;

$totalPhotos = (int)$pdo->query("SELECT COUNT(*) FROM galerie")->fetchColumn();
$totalPages = max(1, (int)ceil($totalPhotos / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare("SELECT * FROM galerie ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($photos as &$photo) {
    if (!empty($photo['image_path']) && strpos($photo['image_path'], 'http') !== 0) {
        $photo['image_path'] = ltrim($photo['image_path'], '/');
    }
}
unset($photo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONG SoDES -- Soutien au Développement par l'Éducation et la Solidarité</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <div class="top-marquee">
            <div class="marquee-content">
                SOUTIEN AU DEVELOPPEMENT PAR L'EDUCATION ET LA SOLIDARITE -- ONG SoDES -- SOUTIEN AU DEVELOPPEMENT PAR L'EDUCATION ET LA SOLIDARITE
            </div>
        </div>

        <nav class="navbar">
            <div class="nav-logo">
                <a href="index.html"><img src="images/logo.png" alt="Logo ONG SoDES"></a>
            </div>

            <ul class="nav-links-desktop">
                <li><a href="index.html" >Accueil</a></li>
                <li><a href="a-propos.html" >A Propos</a></li>
                <li><a href="projets.php">Projets réalisés</a></li>
                <li><a href="galerie.php" class="active">Galerie</a></li>
                <li><a href="contact.php" >Nous contacter</a></li>
            </ul>

            <div class="drawer-action-zone">
                <a href="contact.php" class="drawer-cta-btn">💛 Faire un don</a>
            </div>


            <!-- 🍔 BOUTON MENU BURGER (Invisible sur PC, visible sur Mobile) -->
            <button id="burger-open-btn" class="burger-icon-trigger">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div id="mobile-drawer-menu" class="mobile-navigation-drawer">
                <button id="burger-close-btn" class="close-drawer-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <ul class="drawer-links-list">
                    <li><a href="index.html" class="drawer-link">Accueil</a></li>
                    <li><a href="a-propos.html" class="drawer-link">A Propos</a></li>
                    <li><a href="projets.php" class="drawer-link">Projets réalisés</a></li>
                    <li><a href="galerie.php" class="drawer-link active">Galerie</a></li>
                    <li><a href="contact.php" class="drawer-link  ">Nous contacter</a></li>
                </ul>

                <div class="drawer-action-zone">
                    <a href="contact.php" class="drawer-cta-btn">💛 Faire un don</a>
                </div>
            </div>
        </nav>

    </header>
    <!-- ========================================== -->
<!-- CONTENU PRINCIPAL DE LA GALERIE            -->
<!-- ========================================== -->
    <main class="gallery-main-content">

    <!-- PREMIÈRE SECTION : Titre/Bannière Galerie -->
        <section class="gallery-hero-section">
            <div class="gallery-hero-container">
                <h1>Galerie</h1>
            </div>
        </section>

    <!-- DEUXIÈME SECTION : Galerie dynamique avec pagination -->
        <section class="gallery-grid-section">
            <div class="gallery-content-wrapper">
                <?php if (!empty($photos)): ?>
                    <div class="gallery-main-grid">
                        <?php foreach ($photos as $p): ?>
                            <article class="gallery-item">
                                <img src="<?= htmlspecialchars($p['image_path']) ?>" alt="<?= htmlspecialchars(!empty($p['titre']) ? $p['titre'] : 'Photo galerie SoDES') ?>">
                                <?php if (!empty($p['titre'])): ?>
                                    <div class="gallery-item-caption">
                                        <p><?= htmlspecialchars($p['titre']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($totalPages > 1): ?>
                        <div class="pagination-wrap">
                            <?php if ($page > 1): ?>
                                <a href="galerie.php?page=<?= $page - 1 ?>" class="pagination-btn">&laquo; Précédent</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="galerie.php?page=<?= $i ?>" class="pagination-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="galerie.php?page=<?= $page + 1 ?>" class="pagination-btn">Suivant &raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="gallery-empty">Aucune image disponible pour le moment.</p>
                <?php endif; ?>
            </div>
        </section>

    <section class="movement-section">
            <div class="movement-container">
        
                <h2 class="movement-title">Rejoignez le mouvement SoDES</h2>
        
                <p class="movement-text">
                    Votre soutien, quel que soit sa forme, contribue directement à changer des vies. 
                    Faites un don, devenez bénévole ou partenaire.
                </p>

        <!-- Groupe de boutons alignés horizontalement -->
                <div class="movement-buttons">
                    <a href="contact.php" class="btn-volunteer">Devenir bénévole</a>
            
                    <a href="contact.php" class="btn-donate">
                        <span class="heart-icon">❤</span> Faire un don
                    </a>
                </div>

            </div>
        </section>

</main>

<footer class="main-footer">
        <div class="footer-container">
        
        <!-- Bloc des réseaux sociaux -->
            <div class="footer-socials">
                <a href="#" class="social-box" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i> <!-- Icône Facebook -->
                </a>
                <a href="#" class="social-box" aria-label="Instagram">
                    <i class="fab fa-instagram"></i> <!-- Icône Instagram -->
                </a>
                <a href="#" class="social-box" aria-label="X">
                    <i class="fab fa-x-twitter"></i> <!-- Icône X (ex-Twitter) -->
                </a>
            </div>

        <!-- Ligne de séparation stylisée avec ses points aux extrémités -->
            <div class="footer-divider">
                <span class="divider-dot dot-left"></span>
                <hr class="divider-line">
                <span class="divider-dot dot-right"></span>
            </div>

        <!-- Texte de Copyright -->
            <p class="footer-copyright">
                &copy; 2026 SoDES. Tous droits réservés.
            </p>

        </div>
    </footer>
    <script src="./script.js"></script>
</body>
</html>
