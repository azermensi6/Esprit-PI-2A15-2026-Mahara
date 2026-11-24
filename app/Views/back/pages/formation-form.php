<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$modif = $id > 0;
$action = 'index.php?page=admin-formation-form' . ($modif ? '&id=' . $id : '');
$err = fn($champ) => isset($errors[$champ])
    ? '<small class="field-error" style="color:#d62828">' . $e($errors[$champ]) . '</small>' : '';
$sel = fn($champ, $valeur) => (string) $old[$champ] === (string) $valeur ? ' selected' : '';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $modif ? 'Modifier' : 'Ajouter' ?> une formation</h2>
                <p>Ajout et modification d'une formation</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-formations">Formations</a></li><li class="breadcrumb-item active" aria-current="page"><?= $modif ? 'Modifier' : 'Ajouter' ?> une formation</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form id="form-formation" class="card-style mb-30" action="<?= $e($action) ?>" method="post" novalidate>
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Titre</label>
                  <input id="titre" name="titre" type="text" placeholder="Ex. PHP et MySQL pour débutants" maxlength="150" value="<?= $e($old['titre']) ?>" />
                  <small class="field-error" id="err-titre" style="color:#d62828"></small>
                  <?= $err('titre') ?>
                </div>
                <div class="input-style">
                  <label for="categorie">Catégorie</label>
                  <select id="categorie" name="id_categorie_formation">
                    <option value="">Choisir…</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?= (int) $c['id_categorie_formation'] ?>"<?= $sel('id_categorie_formation', $c['id_categorie_formation']) ?>><?= $e($c['nom']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <small class="field-error" id="err-id_categorie_formation" style="color:#d62828"></small>
                  <?= $err('id_categorie_formation') ?>
                </div>
                <div class="input-style">
                  <label for="niveau">Niveau</label>
                  <select id="niveau" name="niveau">
                    <option value="debutant"<?= $sel('niveau', 'debutant') ?>>Débutant</option>
                    <option value="intermediaire"<?= $sel('niveau', 'intermediaire') ?>>Intermédiaire</option>
                    <option value="avance"<?= $sel('niveau', 'avance') ?>>Avancé</option>
                  </select>
                  <?= $err('niveau') ?>
                </div>
                <div class="input-style">
                  <label for="duree">Durée (heures)</label>
                  <input id="duree" name="duree_heures" type="number" value="<?= $e($old['duree_heures']) ?>" />
                  <small class="field-error" id="err-duree_heures" style="color:#d62828"></small>
                  <?= $err('duree_heures') ?>
                </div>
                <div class="input-style">
                  <label for="mode">Mode</label>
                  <select id="mode" name="mode">
                    <option value="en_ligne"<?= $sel('mode', 'en_ligne') ?>>En ligne</option>
                    <option value="presentiel"<?= $sel('mode', 'presentiel') ?>>Présentiel</option>
                    <option value="hybride"<?= $sel('mode', 'hybride') ?>>Hybride</option>
                  </select>
                  <?= $err('mode') ?>
                </div>
                <div class="input-style">
                  <label for="prix">Prix (TND)</label>
                  <input id="prix" name="prix" type="number" value="<?= $e($old['prix']) ?>" step="0.5" />
                  <small class="field-error" id="err-prix" style="color:#d62828"></small>
                  <?= $err('prix') ?>
                </div>
                <div class="input-style">
                  <label for="debut">Date de début</label>
                  <input id="debut" name="date_debut" type="date" value="<?= $e($old['date_debut']) ?>" />
                  <small class="field-error" id="err-date_debut" style="color:#d62828"></small>
                  <?= $err('date_debut') ?>
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"><?= $e($old['description']) ?></textarea>
                  <small>Le programme, les prérequis et ce que l'étudiant saura faire à la fin.</small>
                  <small class="field-error" id="err-description" style="color:#d62828"></small>
                  <?= $err('description') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-formations" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->

      <script>
        // Validation JavaScript (côté navigateur) : mêmes règles que le PHP
        document.getElementById('form-formation').addEventListener('submit', function (ev) {
          var ok = true;
          var modification = <?= $modif ? 'true' : 'false' ?>;

          function val(id) { return document.getElementById(id).value.trim(); }
          function erreur(champ, message) {
            document.getElementById('err-' + champ).textContent = message;
            if (message) ok = false;
          }

          var titre = val('titre');
          erreur('titre', titre === '' ? 'Le titre est obligatoire.'
                        : (titre.length < 3 || titre.length > 150) ? 'Le titre doit contenir entre 3 et 150 caractères.' : '');

          erreur('id_categorie_formation', val('categorie') === '' ? 'Choisissez une catégorie.' : '');

          var duree = val('duree');
          erreur('duree_heures', (!/^\d+$/.test(duree) || +duree < 1 || +duree > 500)
                 ? 'La durée doit être un nombre entier entre 1 et 500 heures.' : '');

          var prix = val('prix');
          erreur('prix', (prix === '' || isNaN(prix) || +prix < 0) ? 'Le prix doit être un nombre positif ou nul.' : '');

          var debut = val('debut');
          var msgDate = '';
          if (debut !== '') {
            var aujourdhui = new Date().toISOString().slice(0, 10);
            if (!modification && debut < aujourdhui) msgDate = 'La date de début ne peut pas être dans le passé.';
          }
          erreur('date_debut', msgDate);

          erreur('description', val('description').length > 2000 ? 'La description ne doit pas dépasser 2000 caractères.' : '');

          if (!ok) ev.preventDefault();
        });
      </script>
