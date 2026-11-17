<?php
$pageTitle   = 'Mahara | Publier une mission';
$currentPage = 'publier-mission';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Publier une mission</li></ol>
            <h1>Publier une mission</h1>
            <p>Décris ton besoin : les étudiants intéressés t'enverront leur candidature.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form class="card form-card" action="#" method="post">
                <h3 style="margin-bottom:20px">Ta mission</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="titre">Titre de la mission</label>
                        <input id="titre" name="titre" type="text" class="form-control" placeholder="Ex. Créer la page Facebook de ma pâtisserie" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <select id="categorie" name="id_categorie" class="form-control" required>
                            <option value="">Choisir…</option><option>Design</option><option>Développement web</option><option>Réseaux sociaux</option><option>Traduction</option><option>Cours particuliers</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input id="ville" name="ville" type="text" class="form-control" placeholder="Ex. La Marsa">
                    </div>
                    <div class="form-group">
                        <label for="budget">Budget (TND)</label>
                        <input id="budget" name="budget" type="number" min="0" step="0.5" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="delai">Délai (jours)</label>
                        <input id="delai" name="delai_jours" type="number" min="1" class="form-control" required>
                    </div>
                    <div class="form-group full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Explique ce que tu attends, le résultat souhaité, les contraintes…"></textarea>
                        <span class="form-help">Plus ta description est précise, plus les candidatures seront adaptées.</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Publier la mission</button>
                    <a href="index.php?page=missions" class="btn btn-outline">Annuler</a>
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
