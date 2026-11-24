<?php
/**
 * Vue : ajout / modification d'une formation (back office).
 * Reçoit : $id, $old, $errors, $categories (CategorieFormation[]), $niveaux, $modes, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-formation).
 */
$modif  = $id > 0;
$action = 'index.php?page=admin-formation-form' . ($modif ? '&id=' . $id : '');
$err    = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
$sel    = fn(string $champ, string $valeur) => $old[$champ] === $valeur ? ' selected' : '';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $modif ? 'Modifier' : 'Ajouter' ?> une formation</h2>
                <p>Ajout et modification d'une formation</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-formations">Formations</a></li><li class="breadcrumb-item active" aria-current="page"><?= $modif ? 'Modifier' : 'Ajouter' ?> une formation</li></ol></nav>
            </div>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-formation" class="card-style mb-30" action="<?= e($action) ?>" method="post" novalidate data-mode="<?= $modif ? 'modif' : 'ajout' ?>">
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Titre</label>
                  <input id="titre" name="titre" type="text" placeholder="Ex. PHP et MySQL pour débutants" maxlength="150" value="<?= e($old['titre']) ?>" />
                  <?= $err('titre') ?>
                </div>
                <div class="input-style">
                  <label for="categorie">Catégorie</label>
                  <select id="categorie" name="id_categorie_formation">
                    <option value="">Choisir…</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?= $c->getId() ?>"<?= $sel('id_categorie_formation', (string) $c->getId()) ?>><?= e($c->getNom()) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('id_categorie_formation') ?>
                </div>
                <div class="input-style">
                  <label for="niveau">Niveau</label>
                  <select id="niveau" name="niveau">
                    <?php foreach ($niveaux as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $sel('niveau', $valeur) ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('niveau') ?>
                </div>
                <div class="input-style">
                  <label for="duree">Durée (heures)</label>
                  <input id="duree" name="duree_heures" type="number" value="<?= e($old['duree_heures']) ?>" />
                  <?= $err('duree_heures') ?>
                </div>
                <div class="input-style">
                  <label for="mode">Mode</label>
                  <select id="mode" name="mode">
                    <?php foreach ($modes as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $sel('mode', $valeur) ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('mode') ?>
                </div>
                <div class="input-style">
                  <label for="prix">Prix (TND)</label>
                  <input id="prix" name="prix" type="number" value="<?= e($old['prix']) ?>" step="0.5" />
                  <?= $err('prix') ?>
                </div>
                <div class="input-style">
                  <label for="debut">Date de début</label>
                  <input id="debut" name="date_debut" type="date" value="<?= e($old['date_debut']) ?>" />
                  <?= $err('date_debut') ?>
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"><?= e($old['description']) ?></textarea>
                  <small>Le programme, les prérequis et ce que l'étudiant saura faire à la fin.</small>
                  <?= $err('description') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-formations" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
