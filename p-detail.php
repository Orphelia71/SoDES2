<?php
// 1. Connexion BDD
$host = 'localhost'; $dbname = 'sodes_db'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) { die("Erreur"); }

// 2. Récupérer l'ID sécurisé depuis l'URL
$projet_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 3. Récupérer les infos du projet
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$projet_id]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projet) {
    die("Projet introuvable.");
}

// 4. Récupérer les images d'accompagnement
$stmt_img = $pdo->prepare("SELECT * FROM projet_images WHERE projet_id = ?");
$stmt_img->execute([$projet_id]);
$images_supp = $stmt_img->fetchAll(PDO::FETCH_ASSOC);
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
                <li><a href="galerie.php">Galerie</a></li>
                <li><a href="contact.php">Nous contacter</a></li>
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
                    <li><a href="index.html" class="drawer-link ">Accueil</a></li>
                    <li><a href="a-propos.html" class="drawer-link">A Propos</a></li>
                    <li><a href="projets.php" class="drawer-link">Projets réalisés</a></li>
                    <li><a href="galerie.php" class="drawer-link">Galerie</a></li>
                    <li><a href="contact.php" class="drawer-link">Nous contacter</a></li>
                </ul>

                <div class="drawer-action-zone">
                    <a href="contact.php" class="drawer-cta-btn">💛 Faire un don</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
    <!-- Section Hero : Le titre devient dynamique -->
    <section class="projects-hero">
        <div class="projects-hero-container">
            <h1><?= htmlspecialchars($projet['titre']) ?></h1>
        </div>
    </section>

    <section class="project-details-main">
        <div class="project-details-container">
            
            <!-- Ta galerie d'images : Devient dynamique avec la boucle PHP -->
            <div class="project-details-gallery">
                
                <!-- 1. On commence par afficher l'image principale du projet -->
                <div class="project-detail-img">
                    <img src="<?= htmlspecialchars($projet['image_path']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>">
                </div>

                <!-- 2. On affiche les 2 à 4 images supplémentaires si l'admin en a ajouté -->
                <?php if (!empty($images_supp)): ?>
                    <?php foreach ($images_supp as $img): ?>
                        <div class="project-detail-img">
                            <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="Photo d'accompagnement">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <!-- Ton article : La description écrite par l'admin s'affiche ici -->
            <article class="project-details-content">
                <p>
                    <?= nl2br(htmlspecialchars($projet['description'])) ?>
                </p>
            </article>

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