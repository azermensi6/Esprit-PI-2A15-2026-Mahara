<?php
/**
 * Vue partielle : carte des offres (métier avancé, module P3), incluse par offres.php quand ?vue=carte.
 * Couleurs : vert = beaucoup d'offres, orange = quelques offres, jaune = peu d'offres (OffreController::niveauVille()).
 * Reçoit : $carte (points, autres, total — calculés par OffreController::carte()), $actifs (filtres en cours)
 * Dessin en SVG dans la page : aucun service extérieur (respect de la Content-Security-Policy).
 */
$C        = App\Controllers\OffreController::CARTE;
$filtres2 = array_diff_key($actifs, ['ville' => '', 'vue' => '', 'p' => '']);
$urlVille = fn(string $ville) => 'index.php?' . http_build_query(['page' => 'offres'] + $filtres2 + ['ville' => $ville]);
$surCarte = array_sum(array_column($carte['points'], 'nb'));
?>
<div class="carte-offres card">
    <div class="carte-zone">
        <svg viewBox="0 0 <?= $C['largeur'] ?> <?= $C['hauteur'] ?>" role="img" aria-labelledby="carte-titre carte-desc" class="carte-svg">
            <title id="carte-titre">Carte des offres d'emploi en Tunisie</title>
            <desc id="carte-desc"><?= $surCarte ?> offre(s) placée(s) sur <?= count($carte['points']) ?> ville(s). Clique sur une ville pour voir ses offres.</desc>
            <?php require __DIR__ . '/carte-tunisie.php'; ?>
            <g class="carte-points">
                <?php foreach ($carte['points'] as $pt): ?>
                    <a href="<?= e($urlVille($pt['ville'])) ?>" class="carte-point niveau-<?= $pt['niveau'] ?>" aria-label="<?= e($pt['nom']) ?> : <?= $pt['nb'] ?> offre(s)">
                        <title><?= e($pt['nom']) ?> : <?= $pt['nb'] ?> offre(s)</title>
                        <circle cx="<?= $pt['x'] ?>" cy="<?= $pt['y'] ?>" r="<?= $pt['rayon'] ?>"></circle>
                        <text x="<?= $pt['x'] ?>" y="<?= $pt['y'] + 3.5 ?>" text-anchor="middle" class="carte-nb"><?= $pt['nb'] ?></text>
                        <text x="<?= $pt['x'] + $pt['rayon'] + 4 ?>" y="<?= $pt['y'] + 4 ?>" class="carte-nom"><?= e($pt['nom']) ?></text>
                    </a>
                <?php endforeach; ?>
            </g>
        </svg>
    </div>
    <div class="carte-legende">
        <h3>Offres par ville</h3>
        <p class="text-muted">Plus le cercle est grand, plus il y a d'offres. Clique sur une ville pour voir ses offres.</p>
        <ul class="carte-niveaux" aria-label="Signification des couleurs">
            <?php foreach (App\Controllers\OffreController::NIVEAUX as $niveau => $texte): ?>
                <li><span class="pastille niveau-<?= $niveau ?>" aria-hidden="true"></span><?= e($texte) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if ($carte['points'] === [] && $carte['autres'] === []): ?>
            <p class="text-muted">Aucune offre ne correspond à ta recherche pour le moment.</p>
        <?php endif; ?>
        <ul class="carte-liste">
            <?php foreach ($carte['points'] as $pt): ?>
                <li><a href="<?= e($urlVille($pt['ville'])) ?>"><span><?= e($pt['nom']) ?></span><strong class="niveau-<?= $pt['niveau'] ?>"><?= $pt['nb'] ?></strong></a></li>
            <?php endforeach; ?>
        </ul>
        <?php if ($carte['autres'] !== []): ?>
            <h4>Autres villes</h4>
            <ul class="carte-liste">
                <?php foreach ($carte['autres'] as $ville => $v): ?>
                    <li><a href="<?= e($urlVille((string) $ville)) ?>"><span><?= e((string) $ville) ?></span><strong class="niveau-<?= $v['niveau'] ?>"><?= $v['nb'] ?></strong></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <p class="carte-source">Fond de carte : Natural Earth · positions des villes approchées.</p>
    </div>
</div>
