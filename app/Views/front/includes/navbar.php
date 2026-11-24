<?php
// $currentPage est défini en haut de chaque page (ex : 'accueil')
$currentPage = $currentPage ?? 'accueil';

// Visiteur : liens vers les sections de l'accueil (défilement sur l'accueil, sinon retour à l'accueil)
$sectionsAccueil = [
    'espaces'           => 'Espaces',
    'competences'       => 'Compétences',
    'comment-ca-marche' => 'Comment ça marche',
    'missions-recentes' => 'Missions',
];
$ancre = fn(string $id): string => ($currentPage === 'accueil' ? '' : 'index.php?page=accueil') . '#' . $id;

// Membre connecté : liens de son espace selon son rôle (page => libellé)
$liensParRole = [
    'etudiant'  => ['formations' => 'Formations', 'mes-reclamations' => 'Réclamations'],
    'client'    => ['formations' => 'Formations', 'mes-reclamations' => 'Réclamations'],
    'recruteur' => ['formations' => 'Formations', 'mes-reclamations' => 'Réclamations'],
    'admin'     => ['formations' => 'Formations', 'dashboard' => 'Back office'],
];
$liensMembre = isLoggedIn() ? ($liensParRole[currentUser()['role']] ?? []) : [];
?>
    <!-- Navbar Start -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php?page=accueil" class="navbar-brand">
                <img src="app/Views/front/assets/img/logo-icone.png" alt="">
                <span>MAHARA</span>
            </a>
            <button type="button" class="navbar-toggler" aria-label="Ouvrir le menu" aria-expanded="false">
                <svg class="icon" width="28" height="28" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/></svg>
            </button>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
<?php if (!isLoggedIn()): ?>
                    <li><a href="<?= $ancre('haut') ?>" class="nav-link <?= isActive('accueil', $currentPage) ?>">Accueil</a></li>
<?php foreach ($sectionsAccueil as $id => $libelle): ?>
                    <li><a href="<?= $ancre($id) ?>" class="nav-link"><?= $libelle ?></a></li>
<?php endforeach; ?>
<?php else: ?>
<?php foreach ($liensMembre as $page => $libelle): ?>
                    <li><a href="index.php?page=<?= $page ?>" class="nav-link <?= isActive($page, $currentPage) ?>"><?= $libelle ?></a></li>
<?php endforeach; ?>
<?php endif; ?>
                </ul>
            </div>
            <div class="navbar-actions">
<?php if (isLoggedIn()): ?>
                <a href="index.php?page=profil" class="btn btn-outline btn-sm" title="Mon profil"><?= htmlspecialchars(currentUser()['prenom']) ?></a>
                <a href="index.php?page=deconnexion" class="btn btn-primary btn-sm">Déconnexion</a>
<?php else: ?>
                <a href="index.php?page=connexion" class="btn btn-outline btn-sm">Connexion</a>
                <a href="index.php?page=inscription" class="btn btn-primary btn-sm">S'inscrire</a>
<?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
