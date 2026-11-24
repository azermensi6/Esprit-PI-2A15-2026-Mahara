<?php
/**
 * Vue : réclamations de l'utilisateur connecté (front office).
 * Reçoit : $reclamations (Reclamation[]), $stats, $peutDeposer, $maxEnAttente, $types, $statuts, $flash, $csrfToken
 */
$pageTitle   = 'Mahara | Mes réclamations';
$currentPage = 'mes-reclamations';
$badges = ['en_attente' => '', 'en_cours' => 'badge-orange', 'resolue' => 'badge-green', 'rejetee' => 'badge-red'];
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mes réclamations</li></ol>
            <h1>Mes réclamations</h1>
            <p>Signale un problème sur ton compte, une mission, un paiement, une offre ou une formation, et suis sa résolution.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Table Start -->
    <section class="section">
        <div class="container">
            <?php if (!empty($flash)): ?>
                <p role="alert" style="margin-bottom:20px;border-radius:10px;padding:10px 14px;font-weight:600;<?= $flash['type'] === 'success' ? 'background:#e7f6ec;color:#1e7a43' : 'background:#fdecec;color:#a61b1b' ?>"><?= e($flash['message']) ?></p>
            <?php endif; ?>

            <div class="grid grid-4" style="margin-bottom:28px">
                <?php foreach ($statuts as $statut => $libelle): ?>
                    <div class="card stat-card"><span><?= e($libelle) ?></span><strong><?= (int) $stats[$statut] ?></strong></div>
                <?php endforeach; ?>
            </div>

            <div class="result-bar" style="margin-bottom:16px">
                <span><?= count($reclamations) ?> réclamation(s)</span>
                <?php if ($peutDeposer): ?>
                    <a href="index.php?page=reclamation-form" class="btn btn-primary btn-sm">Nouvelle réclamation</a>
                <?php else: ?>
                    <span class="text-muted">Maximum <?= (int) $maxEnAttente ?> réclamations en attente atteint.</span>
                <?php endif; ?>
            </div>

            <div class="card table-card">
                <table class="data-table">
                    <thead><tr><th>Réclamation</th><th>Module</th><th>Date</th><th>Statut</th><th>Réponse de l'équipe</th><th></th></tr></thead>
                    <tbody>
                        <?php if ($reclamations === []): ?>
                            <tr><td colspan="6" class="text-muted">Tu n'as encore déposé aucune réclamation.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($reclamations as $r): /** @var App\Models\Reclamation $r */ ?>
                        <tr>
                            <td><strong><?= e($r->getSujet()) ?></strong><small><?= e(mb_strimwidth($r->getDescription(), 0, 90, '…')) ?></small></td>
                            <td class="nowrap"><?= e($types[$r->getTypeProbleme()] ?? $r->getTypeProbleme()) ?></td>
                            <td class="nowrap"><?= e(dateFr($r->getDateReclamation())) ?></td>
                            <td><span class="badge <?= $badges[$r->getStatut()] ?? '' ?>"><?= e($statuts[$r->getStatut()] ?? $r->getStatut()) ?></span></td>
                            <td>
                                <?php if ($r->getReponse() !== null): ?>
                                    <?= nl2br(e($r->getReponse())) ?>
                                    <small><?= e($r->getAdmin() ?? 'Équipe Mahara') ?><?= $r->getDateTraitement() !== null ? ' · ' . e(dateFr($r->getDateTraitement())) : '' ?></small>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($r->getStatut() === 'en_attente'): ?>
                                <div class="card-actions">
                                    <a href="index.php?page=reclamation-form&amp;id=<?= $r->getId() ?>" class="btn btn-outline btn-sm">Modifier</a>
                                    <form method="post" action="index.php?page=mes-reclamations" style="display:inline">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                        <input type="hidden" name="delete_id" value="<?= $r->getId() ?>">
                                        <button type="submit" class="btn btn-outline btn-sm btn-danger" data-confirm="Retirer cette réclamation ?">Retirer</button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Table End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
