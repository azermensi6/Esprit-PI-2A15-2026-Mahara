<?php
/**
 * Vue : liste des offres d'emploi publiques (front office, module P3).
 * Reçoit : $vue ('liste' ou 'carte'), $carte (si vue carte), $pagination (items OffreEmploi[], page, pages, total),
 *          $villes, $filtres, $types, $tris, $flash, $csrfToken
 * Métiers : recherche + filtres, tri, pagination (simples) · poste accessible, recherche vocale, carte des offres (avancés)
 */
$offres   = $pagination['items'];
$actifs   = array_filter($filtres, fn($v, $k) => $v !== '' && !($k === 'tri' && $v === 'recent'), ARRAY_FILTER_USE_BOTH);
$urlPage  = fn(int $n) => 'index.php?' . http_build_query(['page' => 'offres'] + $actifs + ['p' => $n]);
$urlVue   = fn(string $v) => 'index.php?' . http_build_query(['page' => 'offres'] + $actifs + ($v === 'carte' ? ['vue' => 'carte'] : []));
$pageTitle   = 'Mahara | Offres d\'emploi';
$currentPage = 'offres';
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
                    <?php if ($vue === 'carte'): ?><input type="hidden" name="vue" value="carte"><?php endif; ?>
                    <h3>Filtrer</h3>
                    <div class="form-group">
                        <label for="f-q">Mot-clé</label>
                        <div class="recherche-vocale">
                            <input id="f-q" name="q" type="search" class="form-control" placeholder="Ex. développeur" value="<?= e($filtres['q']) ?>">
                            <!-- Métier avancé : recherche vocale (affiché seulement si le navigateur sait le faire) -->
                            <button type="button" class="btn-micro" data-micro="f-q" aria-label="Rechercher à la voix" title="Rechercher à la voix" hidden>&#127908;</button>
                        </div>
                        <small class="statut-micro" aria-live="polite"></small>
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
                    <div class="form-group">
                        <!-- Métier avancé : postes accessibles aux personnes en situation de handicap -->
                        <label class="check"><input type="checkbox" name="accessible" value="1"<?= $filtres['accessible'] === '1' ? ' checked' : '' ?>> &#9855; Postes accessibles seulement</label>
                    </div>
                    <div class="form-group">
                        <label for="f-tri">Trier par</label>
                        <select id="f-tri" name="tri" class="form-control">
                            <?php foreach ($tris as $valeur => $libelle): ?>
                                <option value="<?= e($valeur) ?>"<?= $filtres['tri'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Appliquer</button>
                    <?php if ($actifs !== []): ?><a href="<?= $vue === 'carte' ? 'index.php?page=offres&amp;vue=carte' : 'index.php?page=offres' ?>" class="btn btn-outline btn-block" style="margin-top:10px">Effacer les filtres</a><?php endif; ?>
                </form>
                <div>
                    <div class="result-bar">
                        <span><?= $pagination['total'] ?> offre(s) trouvée(s)<?= $vue === 'liste' && $pagination['pages'] > 1 ? ' · page ' . $pagination['page'] . ' sur ' . $pagination['pages'] : '' ?></span>
                        <!-- Métier avancé : choisir entre la liste et la carte des offres -->
                        <nav class="vue-onglets" aria-label="Affichage des offres">
                            <a href="<?= e($urlVue('liste')) ?>" class="<?= $vue === 'liste' ? 'actif' : '' ?>"<?= $vue === 'liste' ? ' aria-current="page"' : '' ?>>&#9776; Liste</a>
                            <a href="<?= e($urlVue('carte')) ?>" class="<?= $vue === 'carte' ? 'actif' : '' ?>"<?= $vue === 'carte' ? ' aria-current="page"' : '' ?>>&#128506; Carte</a>
                        </nav>
                        <?php if ((currentUser()['role'] ?? '') === 'recruteur'): ?>
                            <a href="index.php?page=publier-offre" class="btn btn-primary btn-sm">Publier une offre</a>
                        <?php endif; ?>
                    </div>
                    <?php if ($vue === 'carte'): ?>
                        <?php require __DIR__ . '/carte-offres.php'; ?>
                    <?php else: ?>
                    <?php if ($offres === []): ?>
                        <div class="card"><p class="text-muted">Aucune offre ne correspond à ta recherche pour le moment.</p></div>
                    <?php endif; ?>
                    <div class="grid grid-2">
                    <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ ?>
                    <article class="card mission-card">
                        <div class="top"><span><span class="badge <?= $o->getTypeOffre() === 'stage' ? 'badge-orange' : '' ?>"><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?></span><?php if ($o->isAccessible()): ?> <span class="badge badge-accessible" title="Poste accessible aux personnes en situation de handicap">&#9855; Accessible</span><?php endif; ?></span><span class="price"><?= e($o->getSalaireTexte()) ?></span></div>
                        <h3><?= e($o->getTitre()) ?></h3>
                        <div class="ligne-ent"><?php $logoNom = $o->getEntreprise(); $logoFichier = $o->getEntrepriseLogo(); $logoTaille = 40; require __DIR__ . '/logo-entreprise.php'; ?><a href="index.php?page=entreprise&amp;id=<?= $o->getIdEntreprise() ?>" class="lien-entreprise"><?= e($o->getEntreprise()) ?></a></div>
                        <div class="meta"><span><?= e($o->getVille() ?? '—') ?></span><span><?= $o->getDateLimite() !== null ? 'Jusqu\'au ' . e(dateFr($o->getDateLimite())) : 'Sans date limite' ?></span></div>
                        <a href="index.php?page=offre-detail&amp;id=<?= $o->getId() ?>" class="btn btn-dark btn-sm" style="align-self:flex-start">Voir l'offre <span class="fleche" aria-hidden="true">&rarr;</span></a>
                    </article>
                    <?php endforeach; ?>
                    </div>

                    <?php if ($pagination['pages'] > 1): ?>
                    <!-- Métier simple : pagination -->
                    <nav class="pagination-offres" aria-label="Pages des offres">
                        <?php if ($pagination['page'] > 1): ?><a href="<?= e($urlPage($pagination['page'] - 1)) ?>" class="btn btn-outline btn-sm">&larr; Précédente</a><?php endif; ?>
                        <?php for ($n = 1; $n <= $pagination['pages']; $n++): ?>
                            <a href="<?= e($urlPage($n)) ?>" class="btn btn-sm <?= $n === $pagination['page'] ? 'btn-dark' : 'btn-outline' ?>"<?= $n === $pagination['page'] ? ' aria-current="page"' : '' ?>><?= $n ?></a>
                        <?php endfor; ?>
                        <?php if ($pagination['page'] < $pagination['pages']): ?><a href="<?= e($urlPage($pagination['page'] + 1)) ?>" class="btn btn-outline btn-sm">Suivante &rarr;</a><?php endif; ?>
                    </nav>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Listing End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
<script src="app/Views/front/assets/js/recrutement.js"></script>
</body>

</html>
