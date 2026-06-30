<?php
// Variables pour afficher un message de confirmation ou d'erreur à l'utilisateur
$success_msg = "";
$error_msg = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_contact'])) {
    
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

    // 2. Récupération et sécurisation des données saisies
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $profil = isset($_POST['profil']) ? trim($_POST['profil']) : 'Autre';
    $objet = trim($_POST['objet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // 3. Validation rapide
    if (!empty($nom) && !empty($prenom) && !empty($objet) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // 4. Préparation de la requête d'insertion
        $sql = "INSERT INTO contacts (nom, prenom, email, profil, objet, message) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nom, $prenom, $email, $profil, $objet, $message])) {
            $success_msg = "Votre message a bien été envoyé ! Merci pour votre engagement.";
        } else {
            $error_msg = "Une erreur est survenue lors de l'envoi. Veuillez réessayer.";
        }
    } else {
        $error_msg = "Veuillez remplir correctement tous les champs obligatoires.";
    }
}
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
                <li><a href="contact.php" class="active">Nous contacter</a></li>
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
                    <li><a href="galerie.php" class="drawer-link">Galerie</a></li>
                    <li><a href="contact.php" class="drawer-link  active">Nous contacter</a></li>
                </ul>

                <div class="drawer-action-zone">
                    <a href="contact.php" class="drawer-cta-btn">💛 Faire un don</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        
        <section class="contact-hero">
            <div class="contact-hero-container">
                <h1>Nous contacter</h1>
            </div>
        </section>


        
        <section class="contact-body-section">
            <div class="contact-body-container">
        
        <!-- ================================== -->
        <!-- BLOC GAUCHE : LES COORDONNÉES      -->
        <!-- ================================== -->
                <div class="contact-info-left">
                    <span class="green-badge">NOUS CONTACTER</span>
                    <h2>Nous soutenir</h2>
                    <p class="intro-text">
                        Que vous souhaitiez nous soutenir, collaborer, ou simplement en savoir plus sur nos actions, nous sommes à votre écoute.
                    </p>

            <!-- Les 3 cartes grises arrondies -->
                    <div class="info-cards-stack">
                
                <!-- Téléphone -->
                        <div class="info-card-item">
                            <div class="icon-circle phone-icon-bg">
                        <!-- Tu peux utiliser FontAwesome ou une image svg -->
                                <i class="fa-solid fa-phone"></i> 
                            </div>
                            <div class="card-text-content">
                                <h3>Téléphone direct</h3>
                                <p>+229 0197429201/ 0143747566/ 0194492200</p>
                            </div>
                        </div>

                <!-- Email -->
                        <div class="info-card-item">
                            <div class="icon-circle email-icon-bg">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="card-text-content">
                                <h3>Email</h3>
                                <p>Sodesong57@gmail.com</p>
                            </div>
                        </div>

                <!-- Adresse -->
                        <div class="info-card-item">
                            <div class="icon-circle address-icon-bg">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="card-text-content">
                                <h3>Adresse</h3>
                                <p>Abomey-Calavi, Qtier: Adjagbo, Maison: AZAGOUN</p>
                            </div>
                        </div>

                    </div>
                </div>

        <!-- ================================== -->
        <!-- BLOC DROIT : LE FORMULAIRE BLEU    -->
        <!-- ================================== -->
                <div class="contact-form-right">
                    <h3>Envoyez-nous un message</h3>
                    <p class="form-required-notice">Tous les champs marqués sont requis</p>

                    <form action="contact.php" method="POST" class="contact-inner-form">
                        <input type="hidden" name="submit_contact" value="1">

                        <?php if (!empty($success_msg)): ?>
                        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600; text-align: center;">
                            <?= htmlspecialchars($success_msg); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($error_msg)): ?>
                        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600; text-align: center;">
                            <?= htmlspecialchars($error_msg); ?>
                        </div>
                        <?php endif; ?>

                        <div class="form-inline-row">
                            <div class="input-control">
                                <label>Nom <span class="star">*</span></label>
                                <input type="text" name="nom" required placeholder="TOPANOU">
                            </div>
                            <div class="input-control">
                                <label>Prénom <span class="star">*</span></label>
                                <input type="text" name="prenom" required placeholder="Emmanuel">
                            </div>
                        </div>

                        <div class="input-control">
                            <label>Email <span class="star">*</span></label>
                            <input type="email" name="email" required placeholder="topanouE@gmail.com">
                        </div>

                        <div class="input-control">
                            <label>Vous êtes ?</label>
                            <div class="profile-tags-group">
                                <label class="profile-tag active">
                                    <input type="radio" name="profil" value="Donateur" checked>
                                    <span class="dot"></span>
                                    Donateur
                                </label>
                                <label class="profile-tag">
                                    <input type="radio" name="profil" value="Partenaire">
                                    <span class="dot"></span>
                                    Partenaire
                                </label>
                                <label class="profile-tag">
                                    <input type="radio" name="profil" value="Journaliste">
                                    <span class="dot"></span>
                                    Journaliste
                                </label>
                                <label class="profile-tag">
                                    <input type="radio" name="profil" value="Bénévole">
                                    <span class="dot"></span>
                                    Bénévole
                                </label>
                                <label class="profile-tag">
                                    <input type="radio" name="profil" value="Autre">
                                    <span class="dot"></span>
                                    Autre
                                </label>
                            </div>
                        </div>

                        <div class="input-control custom-select-field">
                            <label>Objet <span class="star">*</span></label>
                            <select name="objet" required>
                                <option value="" disabled selected>Sélectionnez un objet...</option>
                                <option value="Faire un don">Faire un don</option>
                                <option value="Devenir bénévole">Devenir bénévole</option>
                                <option value="Proposition de partenariat">Proposition de partenariat</option>
                                <option value="Demande d'information">Demande d'information</option>
                                <option value="Demande média / Presse">Demande média / Presse</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        <div class="input-control">
                            <label>Message <span class="star">*</span></label>
                            <textarea name="message" required placeholder="Votre message..."></textarea>
                        </div>

                        <button type="submit" class="submit-yellow-btn">Soumettre le formulaire</button>
                    </form>
                </div>

            </div>
        </section>

        <section class="contact-map-static-section">
                <img src="images/cont.png" alt="Carte géographique de l'ONG SoDES à Adjagbo">
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

    <script>
        document.querySelectorAll('.profile-tags-group input[type="radio"][name="profil"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.profile-tags-group .profile-tag').forEach(function (tag) {
                    tag.classList.remove('active');
                });

                if (this.checked) {
                    this.closest('.profile-tag').classList.add('active');
                }
            });
        });
    </script>
    <script src="./script.js"></script>
</body>
</html>