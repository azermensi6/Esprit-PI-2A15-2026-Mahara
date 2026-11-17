<?php
$pageTitle   = 'Mahara | Offres d\'emploi';
$currentPage = 'offres';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Offres d'emploi</li></ol>
            <h1>Offres de stage et d'emploi</h1>
            <p>Des entreprises tunisiennes recrutent des étudiants et des jeunes diplômés.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Listing Start -->
    <section class="section">
        <div class="container">
            <div class="listing">
                <aside class="card filters">
                    <h3>Filtrer</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <input id="f-q" type="search" class="form-control" placeholder="Ex. logo">
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800;font-size:14px">Type d'offre</span>
                        <label class="check"><input type="checkbox" checked> Toutes</label>
                        <label class="check"><input type="checkbox"> Stage</label>
                        <label class="check"><input type="checkbox"> Emploi</label>
                    </div>
                    <div class="form-group">
                        <label for="f-ville">Ville</label>
                        <select id="f-ville" class="form-control"><option>Toutes</option><option>Tunis</option><option>Ariana</option><option>Sousse</option><option>Sfax</option><option>Nabeul</option></select>
                    </div>
                    <button type="button" class="btn btn-dark btn-block">Appliquer</button>
                </aside>
                <div>
                    <div class="result-bar"><span>4 offres trouvées</span></div>
                    <div class="grid grid-2">
                    <article class="card mission-card">
                        <div class="top"><span class="badge badge-orange">Stage</span><span class="price">300 TND / mois</span></div>
                        <h3>Stage en design graphique</h3>
                        <div class="meta"><span>Agence Digitale Sfax</span><span>Sfax</span><span>Jusqu'au 15/12/2026</span></div>
                        <a href="#" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Emploi</span><span class="price">1 400 TND / mois</span></div>
                        <h3>Développeur web junior (PHP, MySQL)</h3>
                        <div class="meta"><span>Agence Digitale Sfax</span><span>Sfax</span><span>Jusqu'au 31/12/2026</span></div>
                        <a href="#" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge badge-orange">Stage</span><span class="price">À négocier</span></div>
                        <h3>Stage community manager</h3>
                        <div class="meta"><span>Agence Digitale Sfax</span><span>Sfax</span><span>Jusqu'au —</span></div>
                        <a href="#" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre</a>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge ">Emploi</span><span class="price">1 100 TND / mois</span></div>
                        <h3>Assistant marketing digital</h3>
                        <div class="meta"><span>Start-up Ariana</span><span>Ariana</span><span>Jusqu'au 20/12/2026</span></div>
                        <a href="#" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre</a>
                    </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Listing End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
