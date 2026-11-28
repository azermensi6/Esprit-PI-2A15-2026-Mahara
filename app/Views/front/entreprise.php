<?php
/**
 * Vue : fiche publique d'une entreprise (front office, module P3).
 * Montre la relation du MCD « Proposer » : une entreprise et toutes ses offres visibles.
 * Reçoit : $entreprise (Entreprise), $offres (OffreEmploi[]), $verifiee, $proprietaire, $types, $csrfToken
 * Métier avancé : logo de l'entreprise (image envoyée, ou rond avec les initiales) — partial logo-entreprise.php
 */
$pageTitle   = 'Mahara | ' . $entreprise->getNom();
$currentPage = 'offres';
$site        = $entreprise->getSiteWeb();
$nbOffres    = count($offres);
$nbStages    = count(array_filter($offres, fn($o) => $o->getTypeOffre() === 'stage'));
$nbAccessibles = count(array_filter($offres, fn($o) => $o->isAccessible()));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<?php require_once __DIR__ . '/includes/head.php'; ?>
<link rel="stylesheet" href="app/Views/front/assets/css/recrutement.css">
<script src="app/Views/front/assets/js/recrutement-theme.js"></script>
</head>

<body>
<?php require_once __DIR__ . '/includes/spinner.php'; ?>
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- ========== Contenu spécifique de la page : début ========== -->

    <!-- Header Start -->
    <section class="page-header bandeau-entreprise">
        <div class="container">
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=offres">Offres d'emploi</a></li><li>Entreprise</li></ol>
            <div class="entete-entreprise">
                <?php $logoNom = $entreprise->getNom(); $logoFichier = $entreprise->getLogo(); $logoTaille = 104; require __DIR__ . '/logo-entreprise.php'; ?>
                <div>
                    <h1><?= e($entreprise->getNom()) ?></h1>
                    <p><?= e($entreprise->getSecteur() ?? 'Secteur non précisé') ?><?= $entreprise->getVille() !== null ? ' · ' . e($entreprise->getVille()) : '' ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Header End -->


    <!-- Fiche entreprise Start -->
    <section class="section">
        <div class="container">
            <?php if (!$verifiee): ?>
                <p role="alert" style="margin-bottom:20px;border-radius:10px;padding:10px 14px;font-weight:600;background:#fdecec;color:#a61b1b">
                    Cette entreprise n'est pas encore visible sur le site : elle doit d'abord être vérifiée par l'équipe Mahara.
                </p>
            <?php endif; ?>

            <div class="detail-grid">
                <!-- Ses offres (relation 1 → N) -->
                <div>
                    <h2 style="margin-bottom:6px">Offres proposées (<?= $nbOffres ?>)</h2>
                    <p class="text-muted" style="margin-bottom:20px">Les offres de cette entreprise encore ouvertes, les plus récentes d'abord.</p>

                    <?php if ($offres === []): ?>
                        <div class="card"><p class="text-muted">Cette entreprise n'a pas d'offre ouverte pour le moment.</p></div>
                    <?php else: ?>
                    <div class="grid grid-2">
                    <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ ?>
                    <article class="card mission-card">
                        <div class="top"><span><span class="badge <?= $o->getTypeOffre() === 'stage' ? 'badge-orange' : '' ?>"><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?></span><?php if ($o->isAccessible()): ?> <span class="badge badge-accessible" title="Poste accessible aux personnes en situation de handicap">&#9855; Accessible</span><?php endif; ?></span><span class="price"><?= e($o->getSalaireTexte()) ?></span></div>
                        <h3><?= e($o->getTitre()) ?></h3>
                        <div class="meta"><span><?= e($o->getVille() ?? '—') ?></span><span><?= $o->getDateLimite() !== null ? 'Jusqu\'au ' . e(dateFr($o->getDateLimite())) : 'Sans date limite' ?></span></div>
                        <a href="index.php?page=offre-detail&amp;id=<?= $o->getId() ?>" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre <span class="fleche" aria-hidden="true">&rarr;</span></a>
                    </article>
                    <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Informations de l'entreprise -->
                <aside class="card">
                    <h3 style="margin-bottom:10px">L'entreprise</h3>
                    <div class="info-row"><span>Secteur</span><strong><?= e($entreprise->getSecteur() ?? '—') ?></strong></div>
                    <div class="info-row"><span>Ville</span><strong><?= e($entreprise->getVille() ?? '—') ?></strong></div>
                    <div class="info-row"><span>Site web</span>
                        <?php if ($site !== null): ?>
                            <a href="<?= e($site) ?>" target="_blank" rel="noopener noreferrer"><?= e(preg_replace('#^https?://#i', '', $site)) ?></a>
                        <?php else: ?><strong>—</strong><?php endif; ?>
                    </div>
                    <div class="info-row"><span>Statut</span><strong><?= $verifiee ? '&#10003; Vérifiée par Mahara' : 'En cours de vérification' ?></strong></div>

                    <h3 style="margin:22px 0 10px">En chiffres</h3>
                    <div class="info-row"><span>Offres ouvertes</span><strong><?= $nbOffres ?></strong></div>
                    <div class="info-row"><span>Dont stages</span><strong><?= $nbStages ?></strong></div>
                    <div class="info-row"><span>Postes accessibles &#9855;</span><strong><?= $nbAccessibles ?></strong></div>

                    <?php if ($proprietaire): ?>
                        <a href="index.php?page=mon-entreprise" class="btn btn-primary btn-block" style="margin-top:20px">Gérer mon entreprise</a>
                    <?php else: ?>
                        <a href="mailto:<?= e($entreprise->getRecruteurEmail()) ?>" class="btn btn-primary btn-block" style="margin-top:20px">Contacter le recruteur</a>
                    <?php endif; ?>
                    <a href="index.php?page=offres" class="btn btn-outline btn-block" style="margin-top:10px">Retour aux offres</a>
                </aside>
            </div>
        </div>
    </section>
    <!-- Fiche entreprise End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
<script src="app/Views/front/assets/js/recrutement.js"></script>
</body>

</html>
