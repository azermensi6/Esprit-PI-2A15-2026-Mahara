<?php
/**
 * Vue : liste des offres d'emploi (back office, module P3).
 * Reçoit : $pagination (items OffreEmploi[], page, pages, total), $stats, $entreprises (Entreprise[]), $filtres, $types, $tris,
 *          $statuts, $flash, $csrfToken
 * Métiers simples : recherche, filtres, tri, pagination
 */
$offres  = $pagination['items'];
$actifs  = array_filter($filtres, fn($v, $k) => $v !== '' && !($k === 'tri' && $v === 'recent'), ARRAY_FILTER_USE_BOTH);
$urlPage = fn(int $n) => 'index.php?' . http_build_query(['page' => 'admin-offres'] + $actifs + ['p' => $n]);
$badges    = ['en_attente' => 'warning-btn', 'verifiee' => 'success-btn', 'refusee' => 'danger-btn'];
$actionUrl = 'index.php?' . http_build_query(['page' => 'admin-offres'] + $actifs + ['p' => $pagination['page']]);
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Offres d'emploi</h2>
                <p>Stages et emplois proposés par les entreprises</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Offres d'emploi</li></ol></nav>
            </div>
          </div>

          <!-- Navigation du module : entreprises / offres -->
          <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
            <a href="index.php?page=admin-entreprises" class="main-btn light-btn btn-sm">Entreprises</a>
            <a href="index.php?page=admin-offres" class="main-btn primary-btn btn-sm">Offres d'emploi</a>
            <a href="index.php?page=admin-statistiques-recrutement" class="main-btn light-btn btn-sm">Statistiques</a>
            <a href="index.php?page=admin-offre-form" class="main-btn orange-btn btn-sm" style="margin-left:auto">+ Ajouter une offre</a>
          </div>

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <!-- Compteurs par type : un clic filtre la liste -->
          <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px">
            <?php foreach ($types as $type => $libelle): ?>
              <a href="index.php?page=admin-offres&amp;type=<?= e($type) ?>" class="card-style" style="padding:14px 20px;min-width:150px;text-decoration:none">
                <small class="text-muted"><?= e($libelle) ?></small><br><strong style="font-size:22px"><?= (int) $stats[$type] ?></strong>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <form class="left" action="index.php" method="get">
                  <input type="hidden" name="page" value="admin-offres">
                  <label for="f-q" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="f-q" name="q" type="search" class="form-control" placeholder="Intitulé, description ou entreprise" value="<?= e($filtres['q']) ?>" style="width:260px;max-width:100%" />
                  <label for="f-type" style="position:absolute;left:-9999px">Type</label>
                  <select id="f-type" name="type" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les types</option>
                    <?php foreach ($types as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['type'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="f-entreprise" style="position:absolute;left:-9999px">Entreprise</label>
                  <select id="f-entreprise" name="entreprise" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Toutes les entreprises</option>
                    <?php foreach ($entreprises as $ent): /** @var App\Models\Entreprise $ent */ ?>
                      <option value="<?= $ent->getId() ?>"<?= $filtres['entreprise'] === (string) $ent->getId() ? ' selected' : '' ?>><?= e($ent->getNom()) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="f-tri" style="position:absolute;left:-9999px">Trier par</label>
                  <select id="f-tri" name="tri" class="form-control js-autosubmit" style="width:auto">
                    <?php foreach ($tris as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['tri'] === $valeur ? ' selected' : '' ?>>Tri : <?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label style="display:flex;gap:6px;align-items:center;font-weight:600;font-size:14px;cursor:pointer"><input type="checkbox" name="accessible" value="1" class="js-autosubmit"<?= $filtres['accessible'] === '1' ? ' checked' : '' ?>> &#9855; Accessibles</label>
                  <button type="submit" class="main-btn light-btn btn-sm">Rechercher</button>
                  <?php if ($actifs !== []): ?><a href="index.php?page=admin-offres" class="main-btn light-btn btn-sm">Effacer</a><?php endif; ?>
                </form>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Offre</th><th>Entreprise</th><th>Type</th><th>Salaire</th><th>Publiée le</th><th>Date limite</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($offres === []): ?>
                      <tr><td colspan="8" class="text-muted">Aucune offre ne correspond à la recherche.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ $id = $o->getId(); ?>
                    <tr>
                      <td class="text-muted"><?= $id ?></td>
                      <td class="min-width"><strong><?= e($o->getTitre()) ?></strong><?= $o->isAccessible() ? ' <span title="Poste accessible">&#9855;</span>' : '' ?><br><small class="text-muted"><?= e($o->getVille() ?? '—') ?></small></td>
                      <td class="min-width"><?= e($o->getEntreprise()) ?><br><span class="status-btn <?= $badges[$o->getEntrepriseStatut()] ?? '' ?>" style="font-size:11px;padding:2px 8px"><?= e($statuts[$o->getEntrepriseStatut()] ?? $o->getEntrepriseStatut()) ?></span></td>
                      <td><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?></td>
                      <td class="nowrap"><?= e($o->getSalaireTexte()) ?></td>
                      <td class="nowrap"><?= e(dateFr($o->getDatePublication())) ?></td>
                      <td class="nowrap"><?= e(dateFr($o->getDateLimite())) ?><?php if ($o->estExpiree()): ?><br><span class="status-btn light-btn" style="font-size:11px;padding:2px 8px">Expirée</span><?php endif; ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-offre-form&amp;id=<?= $id ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <form method="post" action="<?= e($actionUrl) ?>" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="delete_id" value="<?= $id ?>">
                            <button type="submit" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette offre ?">Supprimer</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php if ($pagination['pages'] > 1): ?>
              <!-- Métier simple : pagination -->
              <nav aria-label="Pages des offres" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:16px">
                <small class="text-muted" style="margin-right:8px"><?= $pagination['total'] ?> offres · page <?= $pagination['page'] ?> sur <?= $pagination['pages'] ?></small>
                <?php if ($pagination['page'] > 1): ?><a href="<?= e($urlPage($pagination['page'] - 1)) ?>" class="main-btn light-btn btn-sm">&larr;</a><?php endif; ?>
                <?php for ($n = 1; $n <= $pagination['pages']; $n++): ?>
                  <a href="<?= e($urlPage($n)) ?>" class="main-btn btn-sm <?= $n === $pagination['page'] ? 'primary-btn' : 'light-btn' ?>"<?= $n === $pagination['page'] ? ' aria-current="page"' : '' ?>><?= $n ?></a>
                <?php endfor; ?>
                <?php if ($pagination['page'] < $pagination['pages']): ?><a href="<?= e($urlPage($pagination['page'] + 1)) ?>" class="main-btn light-btn btn-sm">&rarr;</a><?php endif; ?>
              </nav>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
