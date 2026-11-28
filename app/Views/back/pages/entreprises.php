<?php
/**
 * Vue : liste des entreprises (back office, module P3).
 * Reçoit : $pagination (items Entreprise[], page, pages, total), $stats, $filtres, $statuts, $tris, $flash, $csrfToken
 * Métiers simples : recherche, filtre par statut, tri, pagination (comme la liste des offres)
 */
$entreprises = $pagination['items'];
$actifs    = array_filter($filtres, fn($v, $k) => $v !== '' && !($k === 'tri' && $v === 'statut'), ARRAY_FILTER_USE_BOTH);
$urlPage   = fn(int $n) => 'index.php?' . http_build_query(['page' => 'admin-entreprises'] + $actifs + ['p' => $n]);
$badges    = ['en_attente' => 'warning-btn', 'verifiee' => 'success-btn', 'refusee' => 'danger-btn'];
$actionUrl = 'index.php?' . http_build_query(['page' => 'admin-entreprises'] + $actifs + ['p' => $pagination['page']]);
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Entreprises</h2>
                <p>Entreprises des recruteurs, à vérifier avant que leurs offres soient visibles</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Entreprises</li></ol></nav>
            </div>
          </div>

          <!-- Navigation du module : entreprises / offres -->
          <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
            <a href="index.php?page=admin-entreprises" class="main-btn primary-btn btn-sm">Entreprises</a>
            <a href="index.php?page=admin-offres" class="main-btn light-btn btn-sm">Offres d'emploi</a>
            <a href="index.php?page=admin-statistiques-recrutement" class="main-btn light-btn btn-sm">Statistiques</a>
            <a href="index.php?page=admin-entreprise-form" class="main-btn orange-btn btn-sm" style="margin-left:auto">+ Ajouter une entreprise</a>
          </div>

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <!-- Compteurs par statut : un clic filtre la liste -->
          <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px">
            <?php foreach ($statuts as $statut => $libelle): ?>
              <a href="index.php?page=admin-entreprises&amp;statut=<?= e($statut) ?>" class="card-style" style="padding:14px 20px;min-width:150px;text-decoration:none">
                <small class="text-muted"><?= e($libelle) ?></small><br><strong style="font-size:22px"><?= (int) $stats[$statut] ?></strong>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <form class="left" action="index.php" method="get">
                  <input type="hidden" name="page" value="admin-entreprises">
                  <label for="f-q" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="f-q" name="q" type="search" class="form-control" placeholder="Nom, secteur, ville ou recruteur" value="<?= e($filtres['q']) ?>" style="width:260px;max-width:100%" />
                  <label for="f-statut" style="position:absolute;left:-9999px">Statut</label>
                  <select id="f-statut" name="statut" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les statuts</option>
                    <?php foreach ($statuts as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['statut'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="f-tri" style="position:absolute;left:-9999px">Trier par</label>
                  <select id="f-tri" name="tri" class="form-control js-autosubmit" style="width:auto">
                    <?php foreach ($tris as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['tri'] === $valeur ? ' selected' : '' ?>>Tri : <?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" class="main-btn light-btn btn-sm">Rechercher</button>
                  <?php if ($actifs !== []): ?><a href="index.php?page=admin-entreprises" class="main-btn light-btn btn-sm">Effacer</a><?php endif; ?>
                </form>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Entreprise</th><th>Recruteur</th><th>Secteur</th><th>Ville</th><th>Offres</th><th>Statut</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($entreprises === []): ?>
                      <tr><td colspan="8" class="text-muted">Aucune entreprise ne correspond à la recherche.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($entreprises as $ent): /** @var App\Models\Entreprise $ent */ $id = $ent->getId(); ?>
                    <tr>
                      <td class="text-muted"><?= $id ?></td>
                      <td class="min-width"><div style="display:flex;align-items:center;gap:10px"><?php $logoNom = $ent->getNom(); $logoFichier = $ent->getLogo(); $logoTaille = 36; require __DIR__ . '/../../front/logo-entreprise.php'; ?><div><strong><?= e($ent->getNom()) ?></strong><br><small class="text-muted"><?= e($ent->getSiteWeb() ?? '—') ?></small></div></div></td>
                      <td class="min-width"><?= e($ent->getRecruteur()) ?><br><small class="text-muted"><?= e($ent->getRecruteurEmail()) ?></small></td>
                      <td><?= e($ent->getSecteur() ?? '—') ?></td>
                      <td class="nowrap"><?= e($ent->getVille() ?? '—') ?></td>
                      <td><a href="index.php?page=admin-offres&amp;entreprise=<?= $id ?>"><?= $ent->getNbOffres() ?></a></td>
                      <td><span class="status-btn <?= $badges[$ent->getStatut()] ?? '' ?>"><?= e($statuts[$ent->getStatut()] ?? $ent->getStatut()) ?></span></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-entreprise-form&amp;id=<?= $id ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <form method="post" action="<?= e($actionUrl) ?>" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <?php if ($ent->getStatut() !== 'verifiee'): ?>
                              <button type="submit" name="action" value="verifier" class="main-btn primary-btn btn-sm" data-confirm="Marquer cette entreprise comme vérifiée ?">Vérifier</button>
                            <?php endif; ?>
                            <?php if ($ent->getStatut() !== 'refusee'): ?>
                              <button type="submit" name="action" value="refuser" class="main-btn light-btn btn-sm" data-confirm="Refuser cette entreprise ? Ses offres ne seront plus visibles.">Refuser</button>
                            <?php endif; ?>
                            <button type="submit" name="action" value="supprimer" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette entreprise et ses <?= $ent->getNbOffres() ?> offre(s) ?">Supprimer</button>
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
              <nav aria-label="Pages des entreprises" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:16px">
                <small class="text-muted" style="margin-right:8px"><?= $pagination['total'] ?> entreprises · page <?= $pagination['page'] ?> sur <?= $pagination['pages'] ?></small>
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
