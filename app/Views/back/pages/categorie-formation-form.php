<?php
/**
 * Vue : ajout / modification d'une catégorie de formation (back office).
 * Reçoit : $id, $old, $errors, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-categorie).
 */
$modif  = $id > 0;
$action = 'index.php?page=admin-categorie-formation-form' . ($modif ? '&id=' . $id : '');
$err    = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $modif ? 'Modifier' : 'Ajouter' ?> une catégorie de formation</h2>
                <p>Ajout et modification d'une catégorie de formation</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-categories-formation">Catégories de formation</a></li><li class="breadcrumb-item active" aria-current="page"><?= $modif ? 'Modifier' : 'Ajouter' ?> une catégorie de formation</li></ol></nav>
            </div>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-categorie" class="card-style mb-30" action="<?= e($action) ?>" method="post" novalidate>
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="nom">Nom de la catégorie</label>
                  <input id="nom" name="nom" type="text" placeholder="Ex. Bureautique" maxlength="80" value="<?= e($old['nom']) ?>" />
                  <?= $err('nom') ?>
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"><?= e($old['description']) ?></textarea>
                  <small>Une ligne affichée aux étudiants dans les filtres.</small>
                  <?= $err('description') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-categories-formation" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
