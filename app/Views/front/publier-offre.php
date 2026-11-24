<?php
$pageTitle   = 'Mahara | Publier une offre';
$currentPage = 'publier-offre';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=mon-entreprise">Mon entreprise</a></li><li>Publier une offre</li></ol>
            <h1>Publier une offre d'emploi</h1>
            <p>Propose un stage ou un emploi aux étudiants et jeunes diplômés de Mahara.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form class="card form-card" action="#" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                <h3 style="margin-bottom:20px">Ton offre</h3>
                <div class="form-grid">
                    <div class="form-group full"><label for="titre">Intitulé du poste</label><input id="titre" name="titre" type="text" class="form-control" placeholder="Ex. Stage en design graphique" required></div>
                    <div class="form-group">
                        <label for="type">Type d'offre</label>
                        <select id="type" name="type_offre" class="form-control" required><option value="">Choisir…</option><option value="stage">Stage</option><option value="emploi">Emploi</option></select>
                    </div>
                    <div class="form-group"><label for="ville">Ville</label><input id="ville" name="ville" type="text" class="form-control" placeholder="Ex. Sfax"></div>
                    <div class="form-group"><label for="salaire">Salaire mensuel (TND)</label><input id="salaire" name="salaire" type="number" min="0" step="10" class="form-control" placeholder="Vide si à négocier"></div>
                    <div class="form-group"><label for="limite">Date limite</label><input id="limite" name="date_limite" type="date" class="form-control"></div>
                    <div class="form-group full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Missions, profil recherché, durée du stage…"></textarea>
                        <span class="form-help">L'offre est publiée au nom de ton entreprise : Agence Digitale Sfax.</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Publier l'offre</button>
                    <a href="index.php?page=mon-entreprise" class="btn btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
