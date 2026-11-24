<?php
$pageTitle   = 'Mahara | Ajouter une réalisation';
$currentPage = 'ajouter-realisation';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=portfolio">Mon portfolio</a></li><li>Ajouter une réalisation</li></ol>
            <h1>Ajouter une réalisation</h1>
            <p>Montre un travail que tu as déjà réalisé : projet de cours, stage, mission…</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form class="card form-card" action="#" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                <h3 style="margin-bottom:20px">Ta réalisation</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="titre">Titre</label>
                        <input id="titre" name="titre" type="text" class="form-control" placeholder="Ex. Logo pour un club universitaire" required>
                    </div>
                    <div class="form-group">
                        <label for="competence">Compétence</label>
                        <select id="competence" name="id_competence" class="form-control" required>
                            <option value="">Choisir…</option><option value="1">Design graphique</option><option value="2">Développement web</option><option value="3">Réseaux sociaux</option><option value="4">Traduction</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date de réalisation</label>
                        <input id="date" name="date_realisation" type="date" class="form-control">
                    </div>
                    <div class="form-group full">
                        <label for="lien">Lien (Behance, GitHub, Drive…)</label>
                        <input id="lien" name="lien" type="url" class="form-control" placeholder="https://">
                    </div>
                    <div class="form-group full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Le contexte, ce que tu as fait, les outils utilisés…"></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Publier la réalisation</button>
                    <a href="index.php?page=portfolio" class="btn btn-outline">Annuler</a>
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
