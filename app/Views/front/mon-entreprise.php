<?php
$pageTitle   = 'Mahara | Mon entreprise';
$currentPage = 'mon-entreprise';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mon entreprise</li></ol>
            <h1>Mon entreprise</h1>
            <p>Les informations de ton entreprise, affichées sur chacune de tes offres.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form class="card form-card" action="#" method="post" style="margin-bottom:28px">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                <h3 style="margin-bottom:20px">Informations de l'entreprise</h3>
                <div class="form-grid">
                    <div class="form-group full"><label for="nom">Nom de l'entreprise</label><input id="nom" name="nom" type="text" class="form-control" value="Agence Digitale Sfax" required></div>
                    <div class="form-group"><label for="secteur">Secteur</label><input id="secteur" name="secteur" type="text" class="form-control" value="Marketing digital"></div>
                    <div class="form-group"><label for="ville">Ville</label><input id="ville" name="ville" type="text" class="form-control" value="Sfax"></div>
                    <div class="form-group full"><label for="site">Site web</label><input id="site" name="site_web" type="url" class="form-control" value="https://digitalsfax.tn"></div>
                </div>
                <div class="form-actions"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
            </form>

            <div class="section-head" style="max-width:820px;margin-left:auto;margin-right:auto"><div><h2>Mes offres</h2><p>3 offres publiées</p></div><a href="index.php?page=publier-offre" class="btn btn-primary"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Publier une offre</a></div>
            <div class="card table-card" style="max-width:820px;margin:0 auto">
                <table class="data-table">
                    <thead><tr><th>Offre</th><th>Type</th><th>Date limite</th><th></th></tr></thead>
                    <tbody>
                        <tr><td><strong>Stage en design graphique</strong><small>Sfax · 300 TND / mois</small></td><td><span class="badge badge-orange">Stage</span></td><td class="nowrap">15/12/2026</td><td><div class="card-actions"><a href="index.php?page=publier-offre" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette offre ?">Supprimer</button></div></td></tr>
                        <tr><td><strong>Développeur web junior</strong><small>Sfax · 1 400 TND / mois</small></td><td><span class="badge">Emploi</span></td><td class="nowrap">31/12/2026</td><td><div class="card-actions"><a href="index.php?page=publier-offre" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette offre ?">Supprimer</button></div></td></tr>
                        <tr><td><strong>Stage community manager</strong><small>Sfax · à négocier</small></td><td><span class="badge badge-orange">Stage</span></td><td class="nowrap">—</td><td><div class="card-actions"><a href="index.php?page=publier-offre" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette offre ?">Supprimer</button></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
