<?php
$pageTitle   = 'Mahara | Mon portfolio';
$currentPage = 'portfolio';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mon portfolio</li></ol>
            <h1>Mon portfolio</h1>
            <p>Tes compétences et tes réalisations : c'est ce que voient les clients quand tu postules.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Portfolio Start -->
    <section class="section">
        <div class="container">
            <div class="card" style="margin-bottom:28px">
                <div class="section-head" style="margin-bottom:16px"><div><h3>Mes compétences</h3><p>Chaque réalisation est rattachée à une compétence : elles s'ajoutent ici automatiquement.</p></div></div>
                <div class="tag-list">
                    <span class="badge">Design graphique · 2 réalisations</span>
                    <span class="badge">Réseaux sociaux · 1 réalisation</span>
                </div>
            </div>

            <div class="section-head"><div><h2>Mes réalisations</h2><p>3 réalisations publiées</p></div><a href="index.php?page=ajouter-realisation" class="btn btn-primary"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une réalisation</a></div>
            <div class="grid grid-3">
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Design graphique</span><span class="text-muted" style="font-size:14px;font-weight:700">10/03/2026</span></div>
                        <h3>Logo pour un club universitaire</h3>
                        <p class="text-muted">Logo et charte couleurs</p>
                        <div class="card-actions"><a href="#" class="btn btn-outline btn-sm">Voir le lien</a><a href="index.php?page=ajouter-realisation" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Design graphique</span><span class="text-muted" style="font-size:14px;font-weight:700">02/05/2026</span></div>
                        <h3>Affiche de la journée des métiers</h3>
                        <p class="text-muted">Affiche A3 imprimée</p>
                        <div class="card-actions"><span class="text-muted" style="font-size:14px">Pas de lien</span><a href="index.php?page=ajouter-realisation" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div>
                    </article>
                    <article class="card mission-card">
                        <div class="top"><span class="badge">Réseaux sociaux</span><span class="text-muted" style="font-size:14px;font-weight:700">01/09/2026</span></div>
                        <h3>Page Instagram d'une boutique</h3>
                        <p class="text-muted">30 publications en un mois</p>
                        <div class="card-actions"><span class="text-muted" style="font-size:14px">Pas de lien</span><a href="index.php?page=ajouter-realisation" class="btn btn-outline btn-sm">Modifier</a><button type="button" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div>
                    </article>
            </div>
        </div>
    </section>
    <!-- Portfolio End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
