<?php
/**
 * Vue : traitement d'une réclamation (back office).
 * Reçoit : $reclamation (Reclamation), $old, $errors, $types, $statuts, $statutsTraitement, $roles, $csrfToken
 */
$r   = $reclamation;
$err = fn(string $champ) => '<small class="field-error" data-erreur="' . $champ . '" style="color:#d62828">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Traiter une réclamation</h2>
                <p>Changer le statut et répondre à l'utilisateur</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-reclamations">Réclamations</a></li><li class="breadcrumb-item active" aria-current="page">Réclamation n° <?= $r->getId() ?></li></ol></nav>
            </div>
          </div>

          <!-- Détail de la réclamation (lecture seule) -->
          <div class="card-style mb-30">
            <h3 style="margin-bottom:8px"><?= e($r->getSujet()) ?></h3>
            <p class="text-muted" style="margin-bottom:16px">
              <?= e($types[$r->getTypeProbleme()] ?? $r->getTypeProbleme()) ?> ·
              déposée le <?= e(dateFr($r->getDateReclamation(), true)) ?> par
              <strong><?= e($r->getAuteur()) ?></strong> (<?= e($roles[$r->getAuteurRole()] ?? $r->getAuteurRole()) ?>, <?= e($r->getAuteurEmail()) ?>)
            </p>
            <p><?= nl2br(e($r->getDescription())) ?></p>
            <p class="text-muted" style="margin-top:16px">
              Statut actuel : <strong><?= e($statuts[$r->getStatut()] ?? $r->getStatut()) ?></strong>
              <?php if ($r->getAdmin() !== null): ?> · traitée par <?= e($r->getAdmin()) ?><?php endif; ?>
              <?php if ($r->getDateTraitement() !== null): ?> · clôturée le <?= e(dateFr($r->getDateTraitement(), true)) ?><?php endif; ?>
            </p>
          </div>

          <div class="form-elements-wrapper">
            <form id="form-traitement" class="card-style mb-30" action="index.php?page=admin-reclamation-form&amp;id=<?= $r->getId() ?>" method="post" novalidate>
              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
              <div class="form-grid">
                <div class="input-style">
                  <label for="statut">Nouveau statut</label>
                  <select id="statut" name="statut">
                    <?php foreach ($statutsTraitement as $valeur): ?>
                      <option value="<?= e($valeur) ?>"<?= $old['statut'] === $valeur ? ' selected' : '' ?>><?= e($statuts[$valeur]) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= $err('statut') ?>
                </div>
                <div class="input-style full">
                  <label for="reponse">Réponse à l'utilisateur</label>
                  <textarea id="reponse" name="reponse" rows="5" maxlength="2000"><?= e($old['reponse']) ?></textarea>
                  <small>Obligatoire (10 caractères minimum) pour passer la réclamation en « Résolue » ou « Rejetée ».</small>
                  <?= $err('reponse') ?>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-reclamations" class="main-btn light-btn">Retour</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
