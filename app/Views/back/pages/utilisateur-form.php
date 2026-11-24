<?php
/**
 * Vue : ajout / modification d'un utilisateur (back office).
 * Reçoit : $id, $moi, $old (valeurs du formulaire), $errors, $roles, $statuts, $mdpMin, $csrfToken
 * La validation JavaScript est dans assets/js/validation.js (formulaire #form-utilisateur).
 */
$modif  = $id > 0;
$action = 'index.php?page=admin-utilisateur-form' . ($modif ? '&id=' . $id : '');
$err    = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2><?= $modif ? 'Modifier' : 'Ajouter' ?> un utilisateur</h2>
                <p>Informations du compte · le statut permet de valider ou de suspendre le compte</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-utilisateurs">Utilisateurs</a></li><li class="breadcrumb-item active" aria-current="page"><?= $modif ? 'Modifier' : 'Ajouter' ?> un utilisateur</li></ol></nav>
            </div>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-utilisateur" class="card-style mb-30" action="<?= e($action) ?>" method="post" novalidate
                  data-mode="<?= $modif ? 'modif' : 'ajout' ?>" data-mdp-min="<?= (int) $mdpMin ?>">
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <?php if ($moi): ?>
                <p class="text-muted" style="margin-bottom:16px">C'est votre compte : le rôle et le statut ne peuvent pas être modifiés.</p>
              <?php endif; ?>
              <div class="form-grid">
                <div class="input-style">
                  <label for="nom">Nom</label>
                  <input id="nom" name="nom" type="text" maxlength="50" value="<?= e($old['nom']) ?>" />
                  <?= $err('nom') ?>
                </div>
                <div class="input-style">
                  <label for="prenom">Prénom</label>
                  <input id="prenom" name="prenom" type="text" maxlength="50" value="<?= e($old['prenom']) ?>" />
                  <?= $err('prenom') ?>
                </div>
                <div class="input-style">
                  <label for="email">Email</label>
                  <input id="email" name="email" type="email" maxlength="100" value="<?= e($old['email']) ?>" />
                  <?= $err('email') ?>
                </div>
                <div class="input-style">
                  <label for="telephone">Téléphone</label>
                  <input id="telephone" name="telephone" type="tel" placeholder="8 chiffres, ex. 22111222" value="<?= e($old['telephone']) ?>" />
                  <?= $err('telephone') ?>
                </div>
                <div class="input-style">
                  <label for="role">Rôle</label>
                  <select id="role" name="role"<?= $moi ? ' disabled' : '' ?>>
                    <option value="">Choisir…</option>
                    <?php foreach ($roles as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $old['role'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('role') ?>
                </div>
                <div class="input-style">
                  <label for="statut">Statut du compte</label>
                  <select id="statut" name="statut"<?= $moi ? ' disabled' : '' ?>>
                    <?php foreach ($statuts as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $old['statut'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('statut') ?>
                </div>
                <div class="input-style">
                  <label for="mdp"><?= $modif ? 'Nouveau mot de passe' : 'Mot de passe' ?></label>
                  <input id="mdp" name="mot_de_passe" type="password" autocomplete="new-password" placeholder="<?= $modif ? 'Laisser vide pour ne pas le changer' : 'Au moins ' . (int) $mdpMin . ' caractères' ?>" />
                  <?= $err('mot_de_passe') ?>
                </div>
                <div class="input-style">
                  <label for="mdp2">Confirmer le mot de passe</label>
                  <input id="mdp2" name="confirmation" type="password" autocomplete="new-password" />
                  <?= $err('confirmation') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-utilisateurs" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
