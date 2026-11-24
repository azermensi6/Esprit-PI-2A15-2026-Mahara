<?php
/**
 * Vue : catalogue des formations (front office).
 * Reçoit : $formations (Formation[]), $categories (CategorieFormation[]), $filtres, $tri, $niveaux, $modes, $csrfToken
 */
$pageTitle   = 'Mahara | Formations';
$currentPage = 'formations';

$prix    = fn(float $p) => $p == 0 ? 'Gratuite'
    : rtrim(rtrim(number_format($p, 2, '.', ''), '0'), '.') . ' TND';
$nb = count($formations);
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Formations</li></ol>
            <h1>Formations</h1>
            <p>Des formations courtes pour progresser dans tes compétences et décrocher plus de missions.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Listing Start -->
    <section class="section">
        <div class="container">
            <div class="listing">
                <form id="f-form" class="card filters" action="index.php" method="get">
                    <input type="hidden" name="page" value="formations">
                    <h3>Rechercher</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <input id="f-q" name="q" type="search" class="form-control" placeholder="Ex. PHP, Canva" value="<?= e($filtres['q']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="f-cat">Catégorie</label>
                        <select id="f-cat" name="categorie" class="form-control">
                            <option value="">Toutes</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c->getId() ?>"<?= $filtres['categorie'] === $c->getId() ? ' selected' : '' ?>><?= e($c->getNom()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800;font-size:14px">Niveau</span>
                        <?php foreach ($niveaux as $valeur => $libelle): ?>
                            <label class="check"><input type="checkbox" name="niveau[]" value="<?= $valeur ?>"<?= in_array($valeur, $filtres['niveaux'], true) ? ' checked' : '' ?>> <?= $libelle ?></label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label for="f-mode">Mode</label>
                        <select id="f-mode" name="mode" class="form-control">
                            <option value="">Tous</option>
                            <?php foreach ($modes as $valeur => $libelle): ?>
                                <option value="<?= $valeur ?>"<?= $filtres['mode'] === $valeur ? ' selected' : '' ?>><?= $libelle ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="f-prix">Prix maximum (TND)</label>
                        <input id="f-prix" name="prix_max" type="number" class="form-control" placeholder="Ex. 50" min="0" value="<?= e($filtres['prix_max']) ?>">
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Rechercher</button>
                </form>
                <div>
                    <div class="result-bar"><span><?= $nb ?> formation<?= $nb > 1 ? 's' : '' ?> trouvée<?= $nb > 1 ? 's' : '' ?></span>
                        <label for="f-tri" style="position:absolute;left:-9999px">Trier</label>
                        <select id="f-tri" name="tri" form="f-form" class="form-control js-autosubmit" style="width:auto">
                            <option value="date"<?= $tri === 'date' ? ' selected' : '' ?>>Prochaines dates</option>
                            <option value="prix"<?= $tri === 'prix' ? ' selected' : '' ?>>Prix croissant</option>
                            <option value="duree"<?= $tri === 'duree' ? ' selected' : '' ?>>Durée</option>
                        </select>
                    </div>
                    <?php if ($nb === 0): ?>
                        <p class="text-muted">Aucune formation ne correspond à ta recherche.</p>
                    <?php endif; ?>
                    <div class="grid grid-2">
                    <?php foreach ($formations as $f): /** @var App\Models\Formation $f */ ?>
                    <article class="card mission-card">
                        <div class="top"><span class="badge"><?= e($f->getCategorie()) ?></span><span class="price"><?= e($prix($f->getPrix())) ?></span></div>
                        <h3><?= e($f->getTitre()) ?></h3>
                        <div class="meta">
                            <span><?= e($niveaux[$f->getNiveau()] ?? $f->getNiveau()) ?></span>
                            <span><?= $f->getDureeHeures() ?> h</span>
                            <span><?= e($modes[$f->getMode()] ?? $f->getMode()) ?></span>
                            <?php if ($f->getDateDebut() !== null): ?><span>Début : <?= e(dateFr($f->getDateDebut())) ?></span><?php endif; ?>
                        </div>
                        <a href="index.php?page=formation-detail&amp;id=<?= $f->getId() ?>" class="btn btn-blue btn-sm" style="align-self:flex-start">Voir la formation</a>
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
