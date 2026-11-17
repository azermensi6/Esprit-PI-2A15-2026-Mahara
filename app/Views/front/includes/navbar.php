<?php
// $currentPage est défini en haut de chaque page (ex : 'accueil')
$currentPage = $currentPage ?? 'accueil';
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
                    <li><a href="index.php?page=accueil" class="nav-link <?= isActive('accueil', $currentPage) ?>">Accueil</a></li>
                    <li><a href="index.php?page=missions" class="nav-link <?= isActive('missions', $currentPage) ?>">Missions</a></li>
                    <li><a href="index.php?page=offres" class="nav-link <?= isActive('offres', $currentPage) ?>">Offres d'emploi</a></li>
                    <li><a href="index.php?page=publier-mission" class="nav-link <?= isActive('publier-mission', $currentPage) ?>">Publier une mission</a></li>
                </ul>
            </div>
            <div class="navbar-actions">
                <a href="index.php?page=connexion" class="btn btn-outline btn-sm">Connexion</a>
                <a href="index.php?page=inscription" class="btn btn-primary btn-sm">S'inscrire</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
