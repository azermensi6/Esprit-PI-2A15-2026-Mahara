<?php
/**
 * Vue : liste des catégories de formation (back office).
 * Reçoit : $categories (CategorieFormation[]), $flash, $csrfToken
 */
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Catégories de formation</h2>
                <p>Catégories des formations proposées aux étudiants</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Catégories de formation</li></ol></nav>
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
                <a href="index.php?page=admin-categories-formation" class="main-btn btn-sm primary-btn">Catégories</a>
                <a href="index.php?page=admin-formations" class="main-btn btn-sm light-btn">Formations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="recherche-table" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="recherche-table" type="search" class="form-control js-filtre-table" placeholder="Rechercher une catégorie" style="width:260px;max-width:100%" />
                </div>
                <a href="index.php?page=admin-categorie-formation-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une catégorie</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Catégorie</th><th>Description</th><th>Formations</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($categories === []): ?>
                      <tr><td colspan="5" class="text-muted">Aucune catégorie pour le moment.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($categories as $c): /** @var App\Models\CategorieFormation $c */ ?>
                    <tr data-filtre>
                      <td class="text-muted"><?= $c->getId() ?></td>
                      <td class="min-width"><strong><?= e($c->getNom()) ?></strong></td>
                      <td><?= e($c->getDescription()) ?></td>
                      <td><?= $c->getNbFormations() ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-categorie-formation-form&amp;id=<?= $c->getId() ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <form method="post" action="index.php?page=admin-categories-formation" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="delete_id" value="<?= $c->getId() ?>">
                            <button type="submit" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette catégorie ?">Supprimer</button>
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
