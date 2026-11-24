<?php
/**
 * Vue : l'entreprise du recruteur connecté et ses offres (front office, module P3).
 * Reçoit : $entreprise (?Entreprise), $offres (OffreEmploi[]), $old, $errors, $statuts, $types, $flash, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-entreprise).
 */
$pageTitle   = 'Mahara | Mon entreprise';
$currentPage = 'mon-entreprise';
$badges = ['en_attente' => 'badge-orange', 'verifiee' => 'badge-green', 'refusee' => 'badge-red'];
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mon entreprise</li></ol>
            <h1>Mon entreprise</h1>
            <p>Les informations de ton entreprise, affichées sur chacune de tes offres.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <?php if (!empty($flash)): ?>
                <p role="alert" style="max-width:820px;margin:0 auto 20px;border-radius:10px;padding:10px 14px;font-weight:600;<?= $flash['type'] === 'success' ? 'background:#e7f6ec;color:#1e7a43' : 'background:#fdecec;color:#a61b1b' ?>"><?= e($flash['message']) ?></p>
            <?php endif; ?>

            <form id="form-entreprise" class="card form-card" action="index.php?page=mon-entreprise" method="post" novalidate style="margin-bottom:28px">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:20px">
                    <h3><?= $entreprise === null ? 'Enregistrer mon entreprise' : 'Informations de l\'entreprise' ?></h3>
                    <?php if ($entreprise !== null): ?>
                        <span class="badge <?= $badges[$entreprise->getStatut()] ?? '' ?>"><?= e($statuts[$entreprise->getStatut()] ?? $entreprise->getStatut()) ?></span>
                    <?php endif; ?>
                </div>
                <?php if ($entreprise === null): ?>
                    <p class="text-muted" style="margin-bottom:16px">Tu n'as pas encore d'entreprise. Enregistre-la : l'équipe Mahara la vérifie, puis tes offres deviennent visibles.</p>
                <?php elseif ($entreprise->getStatut() === 'en_attente'): ?>
                    <p class="text-muted" style="margin-bottom:16px">Ton entreprise est en cours de vérification : tes offres seront visibles dès qu'elle sera validée.</p>
                <?php elseif ($entreprise->getStatut() === 'refusee'): ?>
                    <p style="margin-bottom:16px;color:#a61b1b;font-weight:600">Ton entreprise a été refusée. Corrige ses informations et enregistre-les : elle repassera en vérification.</p>
                <?php endif; ?>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="nom">Nom de l'entreprise</label>
                        <input id="nom" name="nom" type="text" class="form-control" maxlength="100" value="<?= e($old['nom']) ?>">
                        <?= $err('nom') ?>
                    </div>
                    <div class="form-group">
                        <label for="secteur">Secteur</label>
                        <input id="secteur" name="secteur" type="text" class="form-control" maxlength="60" placeholder="Ex. Marketing digital" value="<?= e($old['secteur']) ?>">
                        <?= $err('secteur') ?>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input id="ville" name="ville" type="text" class="form-control" maxlength="60" placeholder="Ex. Sfax" value="<?= e($old['ville']) ?>">
                        <?= $err('ville') ?>
                    </div>
                    <div class="form-group full">
                        <label for="site">Site web</label>
                        <input id="site" name="site_web" type="url" class="form-control" maxlength="255" placeholder="https://..." value="<?= e($old['site_web']) ?>">
                        <?= $err('site_web') ?>
                        <?php if ($entreprise !== null && $entreprise->getStatut() === 'verifiee'): ?>
                            <span class="form-help">Attention : changer le nom de l'entreprise la renvoie en vérification.</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-actions"><button type="submit" class="btn btn-primary"><?= $entreprise === null ? 'Enregistrer mon entreprise' : 'Enregistrer' ?></button></div>
            </form>

            <?php if ($entreprise !== null): ?>
            <div class="section-head" style="max-width:820px;margin-left:auto;margin-right:auto"><div><h2>Mes offres</h2><p><?= count($offres) ?> offre(s) publiée(s)</p></div><a href="index.php?page=publier-offre" class="btn btn-primary"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Publier une offre</a></div>
            <div class="card table-card" style="max-width:820px;margin:0 auto">
                <table class="data-table">
                    <thead><tr><th>Offre</th><th>Type</th><th>Date limite</th><th></th></tr></thead>
                    <tbody>
                        <?php if ($offres === []): ?>
                            <tr><td colspan="4" class="text-muted">Tu n'as encore publié aucune offre.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ ?>
                        <tr>
                            <td><strong><a href="index.php?page=offre-detail&amp;id=<?= $o->getId() ?>"><?= e($o->getTitre()) ?></a></strong><small><?= e($o->getVille() ?? '—') ?> · <?= e($o->getSalaireTexte()) ?></small></td>
                            <td><span class="badge <?= $o->getTypeOffre() === 'stage' ? 'badge-orange' : '' ?>"><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?></span></td>
                            <td class="nowrap"><?= e(dateFr($o->getDateLimite())) ?><?= $o->estExpiree() ? '<small>Expirée</small>' : '' ?></td>
                            <td>
                                <div class="card-actions">
                                    <a href="index.php?page=publier-offre&amp;id=<?= $o->getId() ?>" class="btn btn-outline btn-sm">Modifier</a>
                                    <form method="post" action="index.php?page=mon-entreprise" style="display:inline">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                        <input type="hidden" name="action" value="supprimer_offre">
                                        <input type="hidden" name="id_offre" value="<?= $o->getId() ?>">
                                        <button type="submit" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer cette offre ?">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <form method="post" action="index.php?page=mon-entreprise" style="max-width:820px;margin:28px auto 0;text-align:right">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <input type="hidden" name="action" value="supprimer_entreprise">
                <button type="submit" class="btn btn-outline btn-sm btn-danger" data-confirm="Supprimer ton entreprise ET toutes ses offres ? Cette action est définitive.">Supprimer mon entreprise</button>
            </form>
            <?php endif; ?>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
