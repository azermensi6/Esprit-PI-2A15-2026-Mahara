<?php
$pageTitle   = "Mahara | Détail de l'offre";
$currentPage = 'offre-detail';
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

    <!-- Header Start -->
    <section class="page-header">
        <div class="container">
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=offres">Offres d'emploi</a></li><li>Détail de l'offre</li></ol>
            <h1>Développeur web junior (PHP, MySQL)</h1>
            <p>Agence Digitale Sfax · Sfax · publiée le 05/11/2026</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Detail Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <article class="card">
                    <div class="tag-list" style="margin-bottom:18px"><span class="badge">Emploi</span><span class="badge badge-outline">CDI</span><span class="badge badge-outline">Sfax</span></div>
                    <h3 style="margin-bottom:10px">Description du poste</h3>
                    <p class="text-muted" style="margin-bottom:20px">Au sein de l'équipe technique, tu développes et maintiens les sites de nos clients (commerces, restaurants, cabinets) en PHP et MySQL.</p>
                    <h3 style="margin-bottom:10px">Profil recherché</h3>
                    <ul class="text-muted" style="margin:0 0 20px 18px">
                        <li>Étudiant en dernière année ou jeune diplômé en informatique</li>
                        <li>Bases solides en HTML, CSS, PHP et MySQL</li>
                        <li>Un portfolio Mahara avec au moins une réalisation web</li>
                    </ul>
                    <h3 style="margin-bottom:10px">Pour postuler</h3>
                    <p class="text-muted">Envoie ton CV et le lien de ton portfolio Mahara par email au recruteur avant la date limite.</p>
                </article>
                <aside class="card">
                    <div class="info-row"><span>Salaire</span><strong>1 400 TND / mois</strong></div>
                    <div class="info-row"><span>Date limite</span><strong>31/12/2026</strong></div>
                    <div class="info-row"><span>Ville</span><strong>Sfax</strong></div>
                    <h3 style="margin:22px 0 10px">L'entreprise</h3>
                    <div class="info-row"><span>Nom</span><strong>Agence Digitale Sfax</strong></div>
                    <div class="info-row"><span>Secteur</span><strong>Marketing digital</strong></div>
                    <div class="info-row"><span>Site web</span><a href="#">digitalsfax.tn</a></div>
                    <a href="mailto:rh@digitalsfax.tn" class="btn btn-primary btn-block" style="margin-top:20px">Contacter le recruteur</a>
                    <a href="index.php?page=offres" class="btn btn-outline btn-block" style="margin-top:10px">Retour aux offres</a>
                </aside>
            </div>
        </div>
    </section>
    <!-- Detail End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
