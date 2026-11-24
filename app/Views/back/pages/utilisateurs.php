<?php
/**
 * Vue : liste des utilisateurs (back office).
 * Reçoit : $utilisateurs (Utilisateur[]), $filtres, $roles, $statuts, $flash, $moi (id de l'admin connecté), $csrfToken
 */
$badgesRole   = ['admin' => 'success-btn', 'etudiant' => 'warning-btn', 'client' => 'light-btn', 'recruteur' => ''];
$badgesStatut = ['actif' => 'success-btn', 'en_attente' => 'warning-btn', 'suspendu' => 'danger-btn'];
$actionUrl    = 'index.php?' . http_build_query(['page' => 'admin-utilisateurs'] + array_filter($filtres));
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Utilisateurs</h2>
                <p>Valider les nouveaux comptes et suspendre les comptes abusifs</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Utilisateurs</li></ol></nav>
            </div>
          </div>

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <form class="left" action="index.php" method="get">
                  <input type="hidden" name="page" value="admin-utilisateurs">
                  <label for="f-q" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="f-q" name="q" type="search" class="form-control" placeholder="Rechercher un nom ou un email" value="<?= e($filtres['q']) ?>" style="width:240px;max-width:100%" />
                  <label for="f-role" style="position:absolute;left:-9999px">Rôle</label>
                  <select id="f-role" name="role" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les rôles</option>
                    <?php foreach ($roles as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['role'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="f-statut" style="position:absolute;left:-9999px">Statut</label>
                  <select id="f-statut" name="statut" class="form-control js-autosubmit" style="width:auto">
                    <option value="">Tous les statuts</option>
                    <?php foreach ($statuts as $valeur => $libelle): ?>
                      <option value="<?= e($valeur) ?>"<?= $filtres['statut'] === $valeur ? ' selected' : '' ?>><?= e($libelle) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" class="main-btn light-btn btn-sm">Rechercher</button>
                </form>
                <a href="index.php?page=admin-utilisateur-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter un utilisateur</a>
              </div>
              <p class="text-muted" style="margin-bottom:12px"><?= count($utilisateurs) ?> utilisateur(s)</p>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Utilisateur</th><th>Rôle</th><th>Statut</th><th>Réclamations</th><th>Inscription</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if ($utilisateurs === []): ?>
                      <tr><td colspan="7" class="text-muted">Aucun utilisateur ne correspond à la recherche.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($utilisateurs as $u): /** @var App\Models\Utilisateur $u */ $id = $u->getId(); ?>
                    <tr>
                      <td class="text-muted"><?= $id ?></td>
                      <td class="min-width"><strong><?= e($u->getPrenom() . ' ' . $u->getNom()) ?></strong><?= $id === $moi ? ' <small class="text-muted">(vous)</small>' : '' ?><br><small class="text-muted"><?= e($u->getEmail()) ?></small></td>
                      <td><span class="status-btn <?= $badgesRole[$u->getRole()] ?? '' ?>"><?= e($roles[$u->getRole()] ?? $u->getRole()) ?></span></td>
                      <td><span class="status-btn <?= $badgesStatut[$u->getStatut()] ?? '' ?>"><?= e($statuts[$u->getStatut()] ?? $u->getStatut()) ?></span></td>
                      <td>
                        <?php if ($u->getNbReclamations() > 0): ?>
                          <a href="index.php?page=admin-reclamations&amp;q=<?= urlencode($u->getEmail()) ?>"><?= $u->getNbReclamations() ?></a>
                        <?php else: ?>0<?php endif; ?>
                      </td>
                      <td class="nowrap"><?= e(dateFr($u->getDateInscription())) ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-utilisateur-form&amp;id=<?= $id ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <?php if ($id !== $moi): ?>
                            <form method="post" action="<?= e($actionUrl) ?>" style="display:inline">
                              <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                              <input type="hidden" name="id" value="<?= $id ?>">
                              <?php if ($u->getStatut() !== 'actif'): ?>
                                <button type="submit" name="action" value="valider" class="main-btn primary-btn btn-sm" data-confirm="Activer ce compte ?"><?= $u->getStatut() === 'suspendu' ? 'Réactiver' : 'Valider' ?></button>
                              <?php else: ?>
                                <button type="submit" name="action" value="suspendre" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button>
                              <?php endif; ?>
                              <button type="submit" name="action" value="supprimer" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer définitivement ce compte et ses réclamations ?">Supprimer</button>
                            </form>
                          <?php endif; ?>
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
