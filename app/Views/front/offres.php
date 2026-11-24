<?php
/**
 * Vue : liste des offres d'emploi publiques (front office, module P3).
 * Reçoit : $offres (OffreEmploi[]), $villes, $filtres, $types, $flash, $csrfToken
 */
$pageTitle   = 'Mahara | Offres d\'emploi';
$currentPage = 'offres';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Offres d'emploi</li></ol>
            <h1>Offres de stage et d'emploi</h1>
            <p>Des entreprises tunisiennes recrutent des étudiants et des jeunes diplômés.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Listing Start -->
    <section class="section">
        <div class="container">
            <?php if (!empty($flash)): ?>
                <p role="alert" style="margin-bottom:20px;border-radius:10px;padding:10px 14px;font-weight:600;<?= $flash['type'] === 'success' ? 'background:#e7f6ec;color:#1e7a43' : 'background:#fdecec;color:#a61b1b' ?>"><?= e($flash['message']) ?></p>
            <?php endif; ?>
            <div class="listing">
                <form class="card filters" action="index.php" method="get">
                    <input type="hidden" name="page" value="offres">
                    <h3>Filtrer</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <input id="f-q" name="q" type="search" class="form-control" placeholder="Ex. développeur" value="<?= e($filtres['q']) ?>">
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800;font-size:14px">Type d'offre</span>
                        <label class="check"><input type="radio" name="type" value=""<?= !isset($types[$filtres['type']]) ? ' checked' : '' ?>> Toutes</label>
                        <?php foreach ($types as $valeur => $libelle): ?>
                            <label class="check"><input type="radio" name="type" value="<?= e($valeur) ?>"<?= $filtres['type'] === $valeur ? ' checked' : '' ?>> <?= e($libelle) ?></label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label for="f-ville">Ville</label>
                        <select id="f-ville" name="ville" class="form-control">
                            <option value="">Toutes</option>
                            <?php foreach ($villes as $ville): ?>
                                <option value="<?= e($ville) ?>"<?= $filtres['ville'] === $ville ? ' selected' : '' ?>><?= e($ville) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Appliquer</button>
                    <?php if (array_filter($filtres)): ?><a href="index.php?page=offres" class="btn btn-outline btn-block" style="margin-top:10px">Effacer les filtres</a><?php endif; ?>
                </form>
                <div>
                    <div class="result-bar">
                        <span><?= count($offres) ?> offre(s) trouvée(s)</span>
                        <?php if ((currentUser()['role'] ?? '') === 'recruteur'): ?>
                            <a href="index.php?page=publier-offre" class="btn btn-primary btn-sm">Publier une offre</a>
                        <?php endif; ?>
                    </div>
                    <?php if ($offres === []): ?>
                        <div class="card"><p class="text-muted">Aucune offre ne correspond à ta recherche pour le moment.</p></div>
                    <?php endif; ?>
                    <div class="grid grid-2">
                    <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ ?>
                    <article class="card mission-card">
                        <div class="top"><span class="badge <?= $o->getTypeOffre() === 'stage' ? 'badge-orange' : '' ?>"><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?></span><span class="price"><?= e($o->getSalaireTexte()) ?></span></div>
                        <h3><?= e($o->getTitre()) ?></h3>
                        <div class="meta"><span><?= e($o->getEntreprise()) ?></span><span><?= e($o->getVille() ?? '—') ?></span><span><?= $o->getDateLimite() !== null ? 'Jusqu\'au ' . e(dateFr($o->getDateLimite())) : 'Sans date limite' ?></span></div>
                        <a href="index.php?page=offre-detail&amp;id=<?= $o->getId() ?>" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre</a>
                    </article>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Listing End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
