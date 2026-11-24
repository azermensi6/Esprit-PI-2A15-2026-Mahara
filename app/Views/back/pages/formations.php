<?php
/**
 * Vue : liste des formations (back office).
 * Reçoit : $formations (Formation[]), $categories (CategorieFormation[]), $niveaux, $modes, $flash, $csrfToken
 */
$badgesNiveau = ['debutant' => 'success-btn', 'intermediaire' => 'warning-btn', 'avance' => 'danger-btn'];
$prix = fn(float $p) => $p == 0 ? 'Gratuite' : rtrim(rtrim(number_format($p, 2, '.', ''), '0'), '.') . ' TND';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Formations</h2>
                <p>Formations proposées aux étudiants</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Formations</li></ol></nav>
            </div>
          </div>

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-categories-formation" class="main-btn btn-sm light-btn">Catégories</a>
                <a href="index.php?page=admin-formations" class="main-btn btn-sm primary-btn">Formations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="recherche-table" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="recherche-table" type="search" class="form-control js-filtre-table" placeholder="Rechercher une formation" style="width:260px;max-width:100%" />
                  <label for="filtre-categorie" style="position:absolute;left:-9999px">Filtrer par catégorie</label>
                  <select id="filtre-categorie" class="form-control js-filtre-categorie" style="width:auto">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?= e($c->getNom()) ?>"><?= e($c->getNom()) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <a href="index.php?page=admin-formation-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une formation</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Formation</th><th>Niveau</th><th>Durée</th><th>Mode</th><th>Prix</th><th>Début</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($formations === []): ?>
                      <tr><td colspan="8" class="text-muted">Aucune formation pour le moment.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($formations as $f): /** @var App\Models\Formation $f */ ?>
                    <tr data-filtre data-categorie="<?= e($f->getCategorie()) ?>">
                      <td class="text-muted"><?= $f->getId() ?></td>
                      <td class="min-width"><strong><?= e($f->getTitre()) ?></strong><br><small class="text-muted"><?= e($f->getCategorie()) ?></small></td>
                      <td><span class="status-btn <?= $badgesNiveau[$f->getNiveau()] ?? '' ?>"><?= e($niveaux[$f->getNiveau()] ?? $f->getNiveau()) ?></span></td>
                      <td class="nowrap"><?= $f->getDureeHeures() ?> h</td>
                      <td><?= e($modes[$f->getMode()] ?? $f->getMode()) ?></td>
                      <td class="nowrap"><strong><?= e($prix($f->getPrix())) ?></strong></td>
                      <td class="nowrap"><?= e(dateFr($f->getDateDebut())) ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-formation-form&amp;id=<?= $f->getId() ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <form method="post" action="index.php?page=admin-formations" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="delete_id" value="<?= $f->getId() ?>">
                            <button type="submit" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button>
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
