<?php
$pageTitle   = 'Mahara | Détail de la formation';
$currentPage = 'formation-detail';

$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niveaux = ['debutant' => 'Débutant', 'intermediaire' => 'Intermédiaire', 'avance' => 'Avancé'];
$modes   = ['en_ligne' => 'En ligne', 'presentiel' => 'Présentiel', 'hybride' => 'Hybride'];
$niveau  = $niveaux[$formation['niveau']] ?? $formation['niveau'];
$mode    = $modes[$formation['mode']] ?? $formation['mode'];
$prix    = (float) $formation['prix'] == 0 ? 'Gratuite'
    : rtrim(rtrim(number_format((float) $formation['prix'], 2, '.', ''), '0'), '.') . ' TND';
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
            <h1><?= $e($formation['titre']) ?></h1>
            <p><?= $e($formation['categorie']) ?> · <?= $e(mb_strtolower($niveau)) ?> · <?= (int) $formation['duree_heures'] ?> heures · <?= $e(mb_strtolower($mode)) ?></p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Detail Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <article class="card">
                    <div class="tag-list" style="margin-bottom:18px"><span class="badge"><?= $e($formation['categorie']) ?></span><span class="badge badge-green"><?= $e($niveau) ?></span><span class="badge badge-outline"><?= $e($mode) ?></span></div>
                    <h3 style="margin-bottom:10px">Description</h3>
                    <p class="text-muted"><?= $formation['description'] !== null && $formation['description'] !== ''
                        ? nl2br($e($formation['description']))
                        : 'Aucune description pour le moment.' ?></p>
                </article>
                <aside class="card">
                    <div class="info-row"><span>Prix</span><strong><?= $e($prix) ?></strong></div>
                    <div class="info-row"><span>Durée</span><strong><?= (int) $formation['duree_heures'] ?> heures</strong></div>
                    <div class="info-row"><span>Mode</span><strong><?= $e($mode) ?></strong></div>
                    <div class="info-row"><span>Niveau</span><strong><?= $e($niveau) ?></strong></div>
                    <div class="info-row"><span>Date de début</span><strong><?= $formation['date_debut'] ? $e(date('d/m/Y', strtotime($formation['date_debut']))) : 'À définir' ?></strong></div>
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
