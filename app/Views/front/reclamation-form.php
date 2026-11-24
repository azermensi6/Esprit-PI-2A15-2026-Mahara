<?php
/**
 * Vue : déposer / modifier une réclamation (front office).
 * Reçoit : $id, $old, $errors, $types, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-reclamation).
 */
$pageTitle   = 'Mahara | ' . ($id > 0 ? 'Modifier ma réclamation' : 'Nouvelle réclamation');
$currentPage = 'mes-reclamations';
$action = 'index.php?page=reclamation-form' . ($id > 0 ? '&id=' . $id : '');
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=mes-reclamations">Mes réclamations</a></li><li><?= $id > 0 ? 'Modifier' : 'Nouvelle réclamation' ?></li></ol>
            <h1><?= $id > 0 ? 'Modifier ma réclamation' : 'Nouvelle réclamation' ?></h1>
            <p>Décris le problème le plus précisément possible : l'équipe Mahara te répondra ici.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <form id="form-reclamation" class="card form-card" action="<?= e($action) ?>" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="sujet">Sujet</label>
                        <input id="sujet" name="sujet" type="text" class="form-control" maxlength="150" placeholder="Ex. Paiement non reçu" value="<?= e($old['sujet']) ?>">
                        <?= $err('sujet') ?>
                    </div>
                    <div class="form-group">
                        <label for="type">Module concerné</label>
                        <select id="type" name="type_probleme" class="form-control">
                            <option value="">Choisir…</option>
                            <?php foreach ($types as $valeur => $libelle): ?>
                                <option value="<?= e($valeur) ?>"<?= $old['type_probleme'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $err('type_probleme') ?>
                    </div>
                    <div class="form-group full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="6" maxlength="2000" data-compteur="compteur" placeholder="Que s'est-il passé ? Quelle mission, offre ou formation est concernée ?"><?= e($old['description']) ?></textarea>
                        <small class="form-help"><span id="compteur">0</span> / 2000 caractères (20 minimum)</small>
                        <?= $err('description') ?>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?= $id > 0 ? 'Enregistrer' : 'Envoyer la réclamation' ?></button>
                    <a href="index.php?page=mes-reclamations" class="btn btn-outline">Annuler</a>
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
