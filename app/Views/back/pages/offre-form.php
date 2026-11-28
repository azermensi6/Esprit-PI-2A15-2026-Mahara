<?php
/**
 * Vue : ajouter / modifier une offre d'emploi (back office, module P3).
 * Reçoit : $id, $offre (?OffreEmploi), $old, $errors, $types, $entreprises (Entreprise[]), $statuts, $minDate, $maxDate, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-offre).
 */
$err = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
$action = 'index.php?page=admin-offre-form' . ($id > 0 ? '&id=' . $id : '');
$titre  = $id > 0 ? 'Modifier une offre' : 'Ajouter une offre';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $titre ?></h2>
                <p><?= $offre !== null ? 'Publiée le ' . e(dateFr($offre->getDatePublication())) . ' par ' . e($offre->getEntreprise()) : 'L\'offre est publiée à la date du jour' ?></p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-offres">Offres d'emploi</a></li><li class="breadcrumb-item active" aria-current="page"><?= $titre ?></li></ol></nav>
            </div>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-offre" class="card-style mb-30" action="<?= e($action) ?>" method="post" data-min-date="<?= e($minDate) ?>" data-max-date="<?= e($maxDate) ?>" novalidate>
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <?php if (isset($errors['general'])): ?>
                <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:#d62828"><?= e($errors['general']) ?></div>
              <?php endif; ?>
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Intitulé du poste</label>
                  <input id="titre" name="titre" type="text" maxlength="120" value="<?= e($old['titre']) ?>">
                  <?= $err('titre') ?>
                </div>
                <div class="input-style">
                  <label for="id_entreprise">Entreprise</label>
                  <select id="id_entreprise" name="id_entreprise">
                    <option value="">Choisir…</option>
                    <?php foreach ($entreprises as $ent): /** @var App\Models\Entreprise $ent */ ?>
                      <option value="<?= $ent->getId() ?>"<?= $old['id_entreprise'] === (string) $ent->getId() ? ' selected' : '' ?>><?= e($ent->getNom()) ?> (<?= e($statuts[$ent->getStatut()] ?? $ent->getStatut()) ?>)</option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('id_entreprise') ?>
                </div>
                <div class="input-style">
                  <label for="type_offre">Type d'offre</label>
                  <select id="type_offre" name="type_offre">
                    <option value="">Choisir…</option>
                    <?php foreach ($types as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $old['type_offre'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('type_offre') ?>
                </div>
                <div class="input-style">
                  <label for="ville">Ville</label>
                  <input id="ville" name="ville" type="text" maxlength="60" value="<?= e($old['ville']) ?>">
                  <?= $err('ville') ?>
                </div>
                <div class="input-style">
                  <label for="salaire">Salaire mensuel (TND)</label>
                  <input id="salaire" name="salaire" type="number" min="0" step="10" placeholder="Vide si à négocier" value="<?= e($old['salaire']) ?>">
                  <?= $err('salaire') ?>
                </div>
                <div class="input-style">
                  <label for="date_limite">Date limite</label>
                  <input id="date_limite" name="date_limite" type="date" min="<?= e($minDate) ?>" max="<?= e($maxDate) ?>" value="<?= e($old['date_limite']) ?>">
                  <small>Obligatoire, au plus tard le <?= e(dateFr($maxDate)) ?> (<?= App\Controllers\OffreController::DUREE_MAX_JOURS ?> jours maximum). Après cette date, l'offre disparaît du site.</small>
                  <?= $err('date_limite') ?>
                </div>
                <div class="input-style full">
                  <!-- Métier avancé : poste accessible aux personnes en situation de handicap -->
                  <label style="display:flex;gap:8px;align-items:center;cursor:pointer"><input type="checkbox" name="accessible" value="1" style="width:auto"<?= $old['accessible'] === '1' ? ' checked' : '' ?>> &#9855; Poste accessible aux personnes en situation de handicap</label>
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description" rows="6" maxlength="3000" data-compteur="compteur"><?= e($old['description']) ?></textarea>
                  <small><span id="compteur">0</span> / 3000 caractères (20 minimum)</small>
                  <?= $err('description') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-offres" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
