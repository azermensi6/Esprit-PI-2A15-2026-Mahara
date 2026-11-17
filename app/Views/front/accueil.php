<?php
$pageTitle   = 'Mahara | Accueil';
$currentPage = 'accueil';

/**
 * Lien vers une page réservée aux membres : connecté -> la vraie page,
 * visiteur -> défilement vers une section de l'accueil (#ancre).
 */
$lien = fn(string $page, string $ancre): string => isLoggedIn() ? 'index.php?page=' . $page : '#' . $ancre;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<?php require_once __DIR__ . '/includes/head.php'; ?>
</head>

<body>
<?php require_once __DIR__ . '/includes/spinner.php'; ?>
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- ========== Contenu spécifique de la page : début ========== -->

    <!-- Hero Start -->
    <section class="hero" id="haut">
        <div class="container">
            <div>
                <span class="hero-tag">La plateforme freelance des étudiants tunisiens</span>
                <h1>Ta mahara, <span class="text-blue">ton avenir.</span></h1>
                <p class="lead">Trouve des missions près de chez toi, gagne de l'expérience avant ton diplôme et aide les commerces de ta ville à passer au numérique.</p>
                <form class="search-box" action="index.php">
                    <label for="hero-search" style="position:absolute;left:-9999px">Rechercher une mission</label>
                    <input id="hero-search" type="search" name="q" placeholder="Ex. logo, site web, cours de maths…">
                    <button type="submit" class="btn btn-dark">Rechercher</button>
                </form>
                <div class="hero-roles">
                    <a href="index.php?page=inscription" class="btn btn-primary">Je suis étudiant</a>
                    <a href="<?= $lien('publier-mission', 'espaces') ?>" class="btn btn-outline">Je suis client</a>
                    <a href="<?= $lien('offres', 'espaces') ?>" class="btn btn-outline">Je suis recruteur</a>
                </div>
            </div>
            <div class="hero-visual">
                <article class="card card-shadow mission-card">
                    <div class="top"><span class="badge">Réseaux sociaux</span><span class="price">120 TND</span></div>
                    <h3>Créer la page Facebook d'une pâtisserie</h3>
                    <div class="meta"><span>La Marsa</span><span>3 jours</span><span>Niveau débutant</span></div>
                    <a href="<?= $lien('missions', 'missions-recentes') ?>" class="btn btn-blue btn-block">Postuler</a>
                </article>
                <div class="profile-strip">
                    <div class="avatar">YB</div>
                    <div style="flex:1"><strong>Yasmine B. · Étudiante vérifiée</strong><small>Design graphique · Tunis</small></div>
                    <span class="text-orange"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/></svg></span>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero End -->


    <!-- Roles Start -->
    <section class="section" id="espaces">
        <div class="container">
            <div class="section-head"><div><h2>Un espace pour chacun</h2><p>Trois types de comptes, une seule plateforme.</p></div></div>
            <div class="grid grid-3">
                <article class="card role-card role-etudiant">
                    <svg class="icon" width="30" height="30" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c3 3 9 3 12 0v-5"/><path d="M22 9v6"/></svg>
                    <h3>Étudiant freelance</h3>
                    <p class="text-muted">Tu proposes tes compétences et tu réalises des missions.</p>
                    <ul><li>Profil vérifié et portfolio</li><li>Missions adaptées à ton niveau</li><li>Paiement en dinars et avis clients</li></ul>
                    <a href="index.php?page=inscription" class="btn btn-primary btn-block">Créer mon profil étudiant</a>
                </article>
                <article class="card role-card role-client">
                    <svg class="icon" width="30" height="30" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9l1-5h14l1 5"/><path d="M4 9v11h16V9"/><path d="M4 9h16"/><path d="M10 20v-6h4v6"/></svg>
                    <h3>Client</h3>
                    <p class="text-muted">Tu as un besoin ou un problème, tu le publies et un étudiant le résout.</p>
                    <ul><li>Publie ton besoin en quelques minutes</li><li>Reçois les offres des étudiants</li><li>Paie seulement après validation</li></ul>
                    <a href="<?= $lien('publier-mission', 'comment-ca-marche') ?>" class="btn btn-blue btn-block">Publier un besoin</a>
                </article>
                <article class="card role-card role-recruteur">
                    <svg class="icon" width="30" height="30" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6"/><path d="M15 15l6 6"/></svg>
                    <h3>Recruteur</h3>
                    <p class="text-muted">Tu cherches des talents à embaucher en stage ou en emploi.</p>
                    <ul><li>Recherche par compétence et par ville</li><li>Missions réalisées visibles</li><li>Contacte les meilleurs profils</li></ul>
                    <a href="<?= $lien('offres', 'competences') ?>" class="btn btn-dark btn-block">Trouver des talents</a>
                </article>
            </div>
        </div>
    </section>
    <!-- Roles End -->


    <!-- Skills Start -->
    <section class="section" id="competences" style="padding-top:0">
        <div class="container">
            <div class="section-head"><div><h2>Explore par compétence</h2><p>Des missions adaptées à ton niveau, dans ton quartier ou à distance.</p></div></div>
            <div class="grid grid-4">
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 6l-6 6 6 6"/><path d="M16 6l6 6-6 6"/></svg><strong>Développement web</strong><small>Sites vitrines, boutiques en ligne</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20l4-1 11-11-3-3L5 16z"/><path d="M14 6l3 3"/></svg><strong>Design graphique</strong><small>Logos, affiches, visuels</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v12H8l-4 4z"/></svg><strong>Réseaux sociaux</strong><small>Pages Facebook et Instagram</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h7a2 2 0 0 1 2 2v13a2 2 0 0 0-2-2H3z"/><path d="M21 5h-7a2 2 0 0 0-2 2v13a2 2 0 0 1 2-2h7z"/></svg><strong>Cours particuliers</strong><small>Soutien scolaire, langues</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18"/><path d="M12 3a14 14 0 0 0 0 18"/></svg><strong>Traduction</strong><small>Arabe, français, anglais</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/><path d="M9 10v10"/></svg><strong>Saisie et Excel</strong><small>Tableaux, données, factures</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="13" height="12" rx="2"/><path d="M16 10l5-3v10l-5-3"/></svg><strong>Vidéo et photo</strong><small>Montage, reels, retouche</small></a>
                <a href="<?= $lien('missions', 'missions-recentes') ?>" class="card skill-card highlight"><svg class="icon" width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"/><path d="M5 21V10l7-5 7 5v11"/><path d="M10 21v-5h4v5"/></svg><strong>Missions Ville</strong><small>Pour ta municipalité et les associations</small></a>
            </div>
        </div>
    </section>
    <!-- Skills End -->


    <!-- Steps Start -->
    <section class="section section-alt" id="comment-ca-marche">
        <div class="container">
            <div class="section-head"><h2>Comment ça marche</h2></div>
            <div class="grid grid-3">
                <div class="card step-card"><span class="step-num">1</span><h3>Crée ton profil vérifié</h3><p class="text-muted">Inscris-toi avec ton email universitaire, ajoute tes compétences et ton portfolio.</p></div>
                <div class="card step-card"><span class="step-num blue">2</span><h3>Choisis une mission</h3><p class="text-muted">Filtre les missions par compétence, par budget et par ville.</p></div>
                <div class="card step-card"><span class="step-num orange">3</span><h3>Sois payé en dinars</h3><p class="text-muted">Le paiement est bloqué sur la plateforme, puis versé dès que le client valide ton travail.</p></div>
            </div>
        </div>
    </section>
    <!-- Steps End -->


    <!-- Missions Start -->
    <section class="section" id="missions-recentes">
        <div class="container">
            <div class="section-head"><h2>Missions récentes</h2><a href="<?= $lien('missions', 'missions-ville') ?>" style="font-weight:800">Voir toutes les missions</a></div>
            <div class="grid grid-3">
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Design</span><span class="price">80 TND</span></div>
                        <h3>Logo pour un salon de coiffure</h3>
                        <div class="meta"><span>Sousse</span><span>5 jours</span><span>Débutant</span></div>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Développement</span><span class="price">350 TND</span></div>
                        <h3>Site vitrine pour un artisan potier</h3>
                        <div class="meta"><span>Nabeul</span><span>2 semaines</span><span>Confirmé</span></div>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge badge-orange">Mission Ville</span><span class="price">150 TND</span></div>
                        <h3>Enquête de terrain sur le tri des déchets</h3>
                        <div class="meta"><span>Sfax</span><span>1 semaine</span><span>Débutant</span></div>
                    </article>
            </div>
        </div>
    </section>
    <!-- Missions End -->


    <!-- Smart City Start -->
    <section class="section city-band" id="missions-ville">
        <div class="container">
            <div>
                <span class="badge badge-orange" style="margin-bottom:14px">Ville intelligente</span>
                <h2>Les talents étudiants au service de la ville</h2>
                <p style="margin:16px 0 24px">Municipalités et associations publient des missions citoyennes : enquêtes de terrain, aide numérique aux habitants, cartographie de quartier.</p>
                <a href="<?= $lien('missions', 'rejoindre') ?>" class="btn btn-outline">Découvrir les Missions Ville</a>
            </div>
            <div class="grid grid-2">
                <div class="city-tile"><strong>Missions par quartier</strong><span>Trouver un étudiant près de chez soi.</span></div>
                <div class="city-tile"><strong>Commerces connectés</strong><span>Les étudiants digitalisent les boutiques locales.</span></div>
                <div class="city-tile"><strong>Paiement sécurisé</strong><span>En dinars, versé après validation.</span></div>
                <div class="city-tile"><strong>Coach IA</strong><span>Un assistant pour rédiger son profil ou sa mission.</span></div>
            </div>
        </div>
    </section>
    <!-- Smart City End -->


    <!-- CTA Start -->
    <section class="section" id="rejoindre">
        <div class="container">
            <div class="cta-box">
                <h2>Ton expérience commence avant ton diplôme</h2>
                <p>Inscription gratuite pour les étudiants, avec ton email universitaire.</p>
                <div class="actions">
                    <a href="index.php?page=inscription" class="btn btn-dark">Créer mon profil</a>
                    <a href="<?= $lien('publier-mission', 'espaces') ?>" class="btn btn-outline">Publier un besoin</a>
                    <a href="<?= $lien('offres', 'espaces') ?>" class="btn btn-outline">Recruter un talent</a>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
