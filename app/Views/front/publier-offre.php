<?php
/**
 * Vue : publier / modifier une offre d'emploi (front office, recruteur, module P3).
 * Reçoit : $id, $old, $errors, $types, $entreprise (Entreprise), $statuts, $minDate, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-offre).
 */
$pageTitle   = 'Mahara | ' . ($id > 0 ? 'Modifier mon offre' : 'Publier une offre');
$currentPage = 'publier-offre';
$action = 'index.php?page=publier-offre' . ($id > 0 ? '&id=' . $id : '');
$err    = fn(string $champ) => '<small data-erreur="' . $champ . '" style="color:#a61b1b;font-weight:600">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=mon-entreprise">Mon entreprise</a></li><li><?= $id > 0 ? 'Modifier une offre' : 'Publier une offre' ?></li></ol>
            <h1><?= $id > 0 ? 'Modifier mon offre' : 'Publier une offre d\'emploi' ?></h1>
            <p>Propose un stage ou un emploi aux étudiants et jeunes diplômés de Mahara.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form id="form-offre" class="card form-card" action="<?= e($action) ?>" method="post" data-min-date="<?= e($minDate) ?>" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <h3 style="margin-bottom:20px">Ton offre</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="titre">Intitulé du poste</label>
                        <input id="titre" name="titre" type="text" class="form-control" maxlength="120" placeholder="Ex. Stage en design graphique" value="<?= e($old['titre']) ?>">
                        <?= $err('titre') ?>
                    </div>
                    <div class="form-group">
                        <label for="type">Type d'offre</label>
                        <select id="type" name="type_offre" class="form-control">
                            <option value="">Choisir…</option>
                            <?php foreach ($types as $valeur => $libelle): ?>
                                <option value="<?= e($valeur) ?>"<?= $old['type_offre'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $err('type_offre') ?>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input id="ville" name="ville" type="text" class="form-control" maxlength="60" placeholder="Ex. Sfax" value="<?= e($old['ville']) ?>">
                        <?= $err('ville') ?>
                    </div>
                    <div class="form-group">
                        <label for="salaire">Salaire mensuel (TND)</label>
                        <input id="salaire" name="salaire" type="number" min="0" step="10" class="form-control" placeholder="Vide si à négocier" value="<?= e($old['salaire']) ?>">
                        <?= $err('salaire') ?>
                    </div>
                    <div class="form-group">
                        <label for="limite">Date limite</label>
                        <input id="limite" name="date_limite" type="date" class="form-control" min="<?= e($minDate) ?>" value="<?= e($old['date_limite']) ?>">
                        <?= $err('date_limite') ?>
                    </div>
                    <div class="form-group full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="6" maxlength="3000" data-compteur="compteur" placeholder="Missions, profil recherché, durée du stage…"><?= e($old['description']) ?></textarea>
                        <span class="form-help"><span id="compteur">0</span> / 3000 caractères (20 minimum) · L'offre est publiée au nom de ton entreprise : <?= e($entreprise->getNom()) ?><?= $entreprise->getStatut() !== 'verifiee' ? ' (' . e(mb_strtolower($statuts[$entreprise->getStatut()] ?? '')) . ' : l\'offre sera visible après vérification)' : '' ?>.</span>
                        <?= $err('description') ?>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= $id > 0 ? 'Enregistrer' : 'Publier l\'offre' ?></button>
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
