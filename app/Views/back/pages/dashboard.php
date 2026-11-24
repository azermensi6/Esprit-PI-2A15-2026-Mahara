<?php
/**
 * Vue : tableau de bord (back office).
 * Reçoit : $roles, $libellesRoles, $aValider (Utilisateur[]), $statsReclam, $libellesStatut,
 *          $types, $enAttente (Reclamation[]), $nbFormations
 */
$totalComptes = array_sum($roles);
$maxRole      = max(1, max($roles));
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Tableau de bord</h2>
                <p>Vue d'ensemble : comptes, réclamations et formations</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item active" aria-current="page">Tableau de bord</li></ol></nav>
            </div>
          </div>

          <div class="row-grid cols-4 mb-30">
            <div class="card-style icon-card"><div class="label">Comptes</div><div class="value"><?= $totalComptes ?></div><div class="trend neutral"><?= count($aValider) ?> à valider</div></div>
            <div class="card-style icon-card"><div class="label">Réclamations en attente</div><div class="value"><?= (int) $statsReclam['en_attente'] ?></div><div class="trend neutral"><?= (int) $statsReclam['en_cours'] ?> en cours</div></div>
            <div class="card-style icon-card"><div class="label">Réclamations clôturées</div><div class="value blue"><?= (int) $statsReclam['resolue'] + (int) $statsReclam['rejetee'] ?></div><div class="trend neutral"><?= (int) $statsReclam['resolue'] ?> résolues</div></div>
            <div class="card-style icon-card"><div class="label">Formations</div><div class="value"><?= (int) $nbFormations ?></div><div class="trend neutral">au catalogue</div></div>
          </div>

          <div class="row-grid cols-wide mb-30">
            <div class="card-style">
              <div class="card-head"><h3>Comptes à valider</h3><a href="index.php?page=admin-utilisateurs&amp;statut=en_attente">Voir tout</a></div>
              <div class="table-wrapper">
                <table class="table">
                  <thead><tr><th>Nom</th><th>Rôle</th><th>Inscription</th><th style="text-align:right">Action</th></tr></thead>
                  <tbody>
                    <?php if ($aValider === []): ?>
                      <tr><td colspan="4" class="text-muted">Aucun compte en attente.</td></tr>
                    <?php endif; ?>
                    <?php foreach (array_slice($aValider, 0, 5) as $u): /** @var App\Models\Utilisateur $u */ ?>
                    <tr>
                      <td class="min-width"><strong><?= e($u->getPrenom() . ' ' . $u->getNom()) ?></strong><br><small class="text-muted"><?= e($u->getEmail()) ?></small></td>
                      <td><span class="status-btn warning-btn"><?= e($libellesRoles[$u->getRole()] ?? $u->getRole()) ?></span></td>
                      <td class="nowrap"><?= e(dateFr($u->getDateInscription())) ?></td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form&amp;id=<?= $u->getId() ?>" class="main-btn primary-btn btn-sm">Ouvrir</a></div></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-style">
              <div class="card-head"><h3>Comptes par rôle</h3></div>
              <div class="bars">
                <?php foreach ($roles as $role => $nb): ?>
                  <div class="bar-row"><span><?= e($libellesRoles[$role] ?? $role) ?></span><div class="bar-track"><div class="bar-fill" style="width:<?= (int) round($nb * 100 / $maxRole) ?>%"></div></div><span class="num"><?= $nb ?></span></div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-head"><h3>Réclamations à traiter</h3><a href="index.php?page=admin-reclamations&amp;statut=en_attente">Voir tout</a></div>
            <?php if ($enAttente === []): ?>
              <p class="text-muted">Aucune réclamation en attente.</p>
            <?php endif; ?>
            <?php foreach ($enAttente as $r): /** @var App\Models\Reclamation $r */ ?>
              <div class="list-row">
                <div><strong><?= e($r->getSujet()) ?></strong><small><?= e($r->getAuteur()) ?> · <?= e($types[$r->getTypeProbleme()] ?? $r->getTypeProbleme()) ?> · <?= e(dateFr($r->getDateReclamation())) ?></small></div>
                <a href="index.php?page=admin-reclamation-form&amp;id=<?= $r->getId() ?>" class="main-btn orange-btn btn-sm">Traiter</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
