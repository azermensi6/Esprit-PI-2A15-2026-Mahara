<?php
/**
 * Vue : ajouter / modifier / vérifier une entreprise (back office, module P3).
 * Reçoit : $id, $entreprise (?Entreprise), $offres (OffreEmploi[]), $old, $errors, $statuts, $types, $recruteurs, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-entreprise).
 */
$err = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
$action = 'index.php?page=admin-entreprise-form' . ($id > 0 ? '&id=' . $id : '');
$titre  = $id > 0 ? 'Modifier une entreprise' : 'Ajouter une entreprise';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $titre ?></h2>
                <p>Contrôlez les informations du recruteur, puis donnez votre décision (statut)</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-entreprises">Entreprises</a></li><li class="breadcrumb-item active" aria-current="page"><?= $titre ?></li></ol></nav>
            </div>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-entreprise" class="card-style mb-30" action="<?= e($action) ?>" method="post" enctype="multipart/form-data" novalidate>
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="nom">Nom de l'entreprise</label>
                  <input id="nom" name="nom" type="text" maxlength="100" value="<?= e($old['nom']) ?>">
                  <?= $err('nom') ?>
                </div>
                <div class="input-style">
                  <label for="secteur">Secteur</label>
                  <input id="secteur" name="secteur" type="text" maxlength="60" placeholder="Ex. Marketing digital" value="<?= e($old['secteur']) ?>">
                  <?= $err('secteur') ?>
                </div>
                <div class="input-style">
                  <label for="ville">Ville</label>
                  <input id="ville" name="ville" type="text" maxlength="60" placeholder="Ex. Sfax" value="<?= e($old['ville']) ?>">
                  <?= $err('ville') ?>
                </div>
                <div class="input-style full">
                  <label for="logo">Logo (facultatif)</label>
                  <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
                    <?php $logoNom = $old['nom'] !== '' ? $old['nom'] : 'Entreprise'; $logoFichier = $entreprise?->getLogo(); $logoTaille = 56; require __DIR__ . '/../../front/logo-entreprise.php'; ?>
                    <div style="flex:1;min-width:220px">
                      <input id="logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp" data-taille-max="<?= App\Controllers\EntrepriseController::LOGO_TAILLE_MAX ?>">
                      <small class="text-muted" style="display:block;margin-top:4px">PNG, JPG ou WEBP · 2 Mo maximum.</small>
                      <?php if ($entreprise?->getLogo() !== null): ?>
                        <label style="display:flex;align-items:center;gap:6px;margin-top:6px;font-weight:600"><input type="checkbox" name="supprimer_logo" value="1"> Supprimer le logo actuel</label>
                      <?php endif; ?>
                    </div>
                  </div>
                  <?= $err('logo') ?>
                </div>
                <div class="input-style full">
                  <label for="site_web">Site web</label>
                  <input id="site_web" name="site_web" type="url" maxlength="255" placeholder="https://..." value="<?= e($old['site_web']) ?>">
                  <?= $err('site_web') ?>
                </div>
                <div class="input-style">
                  <label for="id_recruteur">Recruteur (gérant)</label>
                  <select id="id_recruteur" name="id_recruteur">
                    <option value="">Choisir…</option>
                    <?php foreach ($recruteurs as $idR => $libelle): ?>
                      <option value="<?= $idR ?>"<?= $old['id_recruteur'] === (string) $idR ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small>Seuls les recruteurs sans entreprise sont proposés (une entreprise par recruteur).</small>
                  <?= $err('id_recruteur') ?>
                </div>
                <div class="input-style">
                  <label for="statut">Statut</label>
                  <select id="statut" name="statut">
                    <?php foreach ($statuts as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $old['statut'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small>Seules les offres des entreprises vérifiées apparaissent sur le site.</small>
                  <?= $err('statut') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-entreprises" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>

          <?php if ($entreprise !== null): ?>
          <!-- Offres proposées par l'entreprise (relation « Proposer ») -->
          <div class="card-style mb-30">
            <div class="card-head">
              <h3>Offres de l'entreprise (<?= count($offres) ?>)</h3>
              <a href="index.php?page=admin-offre-form&amp;entreprise=<?= $entreprise->getId() ?>" class="main-btn light-btn btn-sm">+ Ajouter une offre</a>
            </div>
            <?php if ($offres === []): ?>
              <p class="text-muted">Aucune offre publiée.</p>
            <?php endif; ?>
            <?php foreach ($offres as $o): /** @var App\Models\OffreEmploi $o */ ?>
              <div class="list-row">
                <div>
                  <strong><a href="index.php?page=admin-offre-form&amp;id=<?= $o->getId() ?>"><?= e($o->getTitre()) ?></a></strong>
                  <small><?= e($types[$o->getTypeOffre()] ?? $o->getTypeOffre()) ?> · <?= e($o->getSalaireTexte()) ?> · publiée le <?= e(dateFr($o->getDatePublication())) ?> · limite <?= e(dateFr($o->getDateLimite())) ?><?= $o->estExpiree() ? ' (expirée)' : '' ?></small>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </section>
      <!-- ========== section end ========== -->
