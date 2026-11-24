<?php
/**
 * Vue : détail d'une offre d'emploi (front office, module P3).
 * Reçoit : $offre (OffreEmploi), $publique, $proprietaire, $types, $csrfToken
 */
$pageTitle   = 'Mahara | ' . $offre->getTitre();
$currentPage = 'offres';
$site        = $offre->getEntrepriseSiteWeb();
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=offres">Offres d'emploi</a></li><li>Détail de l'offre</li></ol>
            <h1><?= e($offre->getTitre()) ?></h1>
            <p><?= e($offre->getEntreprise()) ?><?= $offre->getVille() !== null ? ' · ' . e($offre->getVille()) : '' ?> · publiée le <?= e(dateFr($offre->getDatePublication())) ?></p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Detail Start -->
    <section class="section">
        <div class="container">
            <?php if (!$publique): ?>
                <p role="alert" style="margin-bottom:20px;border-radius:10px;padding:10px 14px;font-weight:600;background:#fdecec;color:#a61b1b">
                    Cette offre n'est pas visible sur le site :
                    <?= $offre->estExpiree() ? 'sa date limite est dépassée.' : 'l\'entreprise n\'est pas encore vérifiée par l\'équipe Mahara.' ?>
                </p>
            <?php endif; ?>
            <div class="detail-grid">
                <article class="card">
                    <div class="tag-list" style="margin-bottom:18px">
                        <span class="badge <?= $offre->getTypeOffre() === 'stage' ? 'badge-orange' : '' ?>"><?= e($types[$offre->getTypeOffre()] ?? $offre->getTypeOffre()) ?></span>
                        <?php if ($offre->getVille() !== null): ?><span class="badge badge-outline"><?= e($offre->getVille()) ?></span><?php endif; ?>
                    </div>
                    <h3 style="margin-bottom:10px">Description du poste</h3>
                    <p class="text-muted" style="margin-bottom:20px"><?= nl2br(e($offre->getDescription() ?? '')) ?></p>
                    <h3 style="margin-bottom:10px">Pour postuler</h3>
                    <p class="text-muted">Envoie ton CV et le lien de ton portfolio Mahara par email au recruteur<?= $offre->getDateLimite() !== null ? ' avant le ' . e(dateFr($offre->getDateLimite())) : '' ?>.</p>
                </article>
                <aside class="card">
                    <div class="info-row"><span>Salaire</span><strong><?= e($offre->getSalaireTexte()) ?></strong></div>
                    <div class="info-row"><span>Date limite</span><strong><?= e(dateFr($offre->getDateLimite())) ?></strong></div>
                    <div class="info-row"><span>Ville</span><strong><?= e($offre->getVille() ?? '—') ?></strong></div>
                    <h3 style="margin:22px 0 10px">L'entreprise</h3>
                    <div class="info-row"><span>Nom</span><strong><?= e($offre->getEntreprise()) ?></strong></div>
                    <div class="info-row"><span>Secteur</span><strong><?= e($offre->getEntrepriseSecteur() ?? '—') ?></strong></div>
                    <div class="info-row"><span>Site web</span>
                        <?php if ($site !== null): ?>
                            <a href="<?= e($site) ?>" target="_blank" rel="noopener noreferrer"><?= e(preg_replace('#^https?://#i', '', $site)) ?></a>
                        <?php else: ?><strong>—</strong><?php endif; ?>
                    </div>
                    <?php if ($proprietaire): ?>
                        <a href="index.php?page=publier-offre&amp;id=<?= $offre->getId() ?>" class="btn btn-primary btn-block" style="margin-top:20px">Modifier mon offre</a>
                    <?php else: ?>
                        <a href="mailto:<?= e($offre->getRecruteurEmail()) ?>?subject=<?= rawurlencode('Candidature : ' . $offre->getTitre()) ?>" class="btn btn-primary btn-block" style="margin-top:20px">Contacter le recruteur</a>
                    <?php endif; ?>
                    <a href="index.php?page=offres" class="btn btn-outline btn-block" style="margin-top:10px">Retour aux offres</a>
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
