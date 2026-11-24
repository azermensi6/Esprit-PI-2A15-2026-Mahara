<?php
/**
 * Vue : détail d'une formation (front office).
 * Reçoit : $formation (Formation), $niveaux, $modes, $csrfToken
 */
$pageTitle   = 'Mahara | Détail de la formation';
$currentPage = 'formation-detail';

$niveau  = $niveaux[$formation->getNiveau()] ?? $formation->getNiveau();
$mode    = $modes[$formation->getMode()] ?? $formation->getMode();
$prix    = $formation->getPrix() == 0 ? 'Gratuite'
    : rtrim(rtrim(number_format($formation->getPrix(), 2, '.', ''), '0'), '.') . ' TND';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=formations">Formations</a></li><li>Détail de la formation</li></ol>
            <h1><?= e($formation->getTitre()) ?></h1>
            <p><?= e($formation->getCategorie()) ?> · <?= e(mb_strtolower($niveau)) ?> · <?= $formation->getDureeHeures() ?> heures · <?= e(mb_strtolower($mode)) ?></p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Detail Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <article class="card">
                    <div class="tag-list" style="margin-bottom:18px"><span class="badge"><?= e($formation->getCategorie()) ?></span><span class="badge badge-green"><?= e($niveau) ?></span><span class="badge badge-outline"><?= e($mode) ?></span></div>
                    <h3 style="margin-bottom:10px">Description</h3>
                    <p class="text-muted"><?= $formation->getDescription() !== null && $formation->getDescription() !== ''
                        ? nl2br(e($formation->getDescription()))
                        : 'Aucune description pour le moment.' ?></p>
                </article>
                <aside class="card">
                    <div class="info-row"><span>Prix</span><strong><?= e($prix) ?></strong></div>
                    <div class="info-row"><span>Durée</span><strong><?= $formation->getDureeHeures() ?> heures</strong></div>
                    <div class="info-row"><span>Mode</span><strong><?= e($mode) ?></strong></div>
                    <div class="info-row"><span>Niveau</span><strong><?= e($niveau) ?></strong></div>
                    <div class="info-row"><span>Date de début</span><strong><?= $formation->getDateDebut() !== null ? e(dateFr($formation->getDateDebut())) : 'À définir' ?></strong></div>
                    <p class="form-help" style="margin-top:16px">Ajoute ensuite ton mini-projet à ton portfolio pour le montrer aux clients.</p>
                    <a href="index.php?page=formations" class="btn btn-outline btn-block" style="margin-top:16px">Retour aux formations</a>
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
