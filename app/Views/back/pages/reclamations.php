<?php
/**
 * Vue : liste des réclamations (back office).
 * Reçoit : $reclamations (Reclamation[]), $stats, $filtres, $types, $statuts, $roles, $flash, $csrfToken
 */
$badges    = ['en_attente' => 'warning-btn', 'en_cours' => '', 'resolue' => 'success-btn', 'rejetee' => 'danger-btn'];
$actionUrl = 'index.php?' . http_build_query(['page' => 'admin-reclamations'] + array_filter($filtres));
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Réclamations</h2>
                <p>Réclamations déposées par les utilisateurs, tous modules confondus</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Réclamations</li></ol></nav>
            </div>
          </div>

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <!-- Compteurs par statut : un clic filtre la liste -->
          <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px">
            <?php foreach ($statuts as $statut => $libelle): ?>
              <a href="index.php?page=admin-reclamations&amp;statut=<?= e($statut) ?>" class="card-style" style="padding:14px 20px;min-width:150px;text-decoration:none">
                <small class="text-muted"><?= e($libelle) ?></small><br><strong style="font-size:22px"><?= (int) $stats[$statut] ?></strong>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <form class="left" action="index.php" method="get">
                  <input type="hidden" name="page" value="admin-reclamations">
                  <label for="f-q" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="f-q" name="q" type="search" class="form-control" placeholder="Sujet, nom ou email" value="<?= e($filtres['q']) ?>" style="width:220px;max-width:100%" />
                  <label for="f-statut" style="position:absolute;left:-9999px">Statut</label>
                  <select id="f-statut" name="statut" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les statuts</option>
                    <?php foreach ($statuts as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['statut'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="f-type" style="position:absolute;left:-9999px">Module</label>
                  <select id="f-type" name="type" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les modules</option>
                    <?php foreach ($types as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['type'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" class="main-btn light-btn btn-sm">Rechercher</button>
                  <?php if (array_filter($filtres)): ?><a href="index.php?page=admin-reclamations" class="main-btn light-btn btn-sm">Effacer</a><?php endif; ?>
                </form>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Réclamation</th><th>Auteur</th><th>Module</th><th>Statut</th><th>Date</th><th>Traitée par</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($reclamations === []): ?>
                      <tr><td colspan="8" class="text-muted">Aucune réclamation ne correspond à la recherche.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($reclamations as $r): /** @var App\Models\Reclamation $r */ $id = $r->getId(); ?>
                    <tr>
                      <td class="text-muted"><?= $id ?></td>
                      <td class="min-width"><strong><?= e($r->getSujet()) ?></strong><br><small class="text-muted"><?= e(mb_strimwidth($r->getDescription(), 0, 70, '…')) ?></small></td>
                      <td class="min-width"><?= e($r->getAuteur()) ?><br><small class="text-muted"><?= e($roles[$r->getAuteurRole()] ?? $r->getAuteurRole()) ?> · <?= e($r->getAuteurEmail()) ?></small></td>
                      <td class="nowrap"><?= e($types[$r->getTypeProbleme()] ?? $r->getTypeProbleme()) ?></td>
                      <td><span class="status-btn <?= $badges[$r->getStatut()] ?? '' ?>"><?= e($statuts[$r->getStatut()] ?? $r->getStatut()) ?></span></td>
                      <td class="nowrap"><?= e(dateFr($r->getDateReclamation())) ?></td>
                      <td><?= $r->getAdmin() !== null ? e($r->getAdmin()) : '<span class="text-muted">Non attribuée</span>' ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-reclamation-form&amp;id=<?= $id ?>" class="main-btn primary-btn btn-sm"><?= in_array($r->getStatut(), ['resolue', 'rejetee'], true) ? 'Voir' : 'Traiter' ?></a>
                          <form method="post" action="<?= e($actionUrl) ?>" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="delete_id" value="<?= $id ?>">
                            <button type="submit" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réclamation ?">Supprimer</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
