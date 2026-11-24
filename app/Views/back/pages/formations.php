<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niveaux = [
    'debutant'      => ['Débutant', 'success-btn'],
    'intermediaire' => ['Intermédiaire', 'warning-btn'],
    'avance'        => ['Avancé', 'danger-btn'],
];
$modes = ['en_ligne' => 'En ligne', 'presentiel' => 'Présentiel', 'hybride' => 'Hybride'];
?>
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Formations</h2>
                <p>Formations proposées aux étudiants</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Formations</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <?php if (!empty($flash)): ?>
            <div role="alert" style="padding:12px 16px;border-radius:8px;margin-bottom:20px;color:#fff;background:<?= $flash['type'] === 'success' ? '#2e9e5b' : '#d62828' ?>">
              <?= $e($flash['message']) ?>
            </div>
          <?php endif; ?>

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-categories-formation" class="main-btn btn-sm light-btn">Catégories</a>
                <a href="index.php?page=admin-formations" class="main-btn btn-sm primary-btn">Formations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-formations-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-formations-search" type="search" class="form-control" placeholder="Rechercher une formation" style="width:260px;max-width:100%" />
                  <label for="admin-formations-filtre" style="position:absolute;left:-9999px">Filtrer</label>
                  <select id="admin-formations-filtre" class="form-control" style="width:auto">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?= $e($c['nom']) ?>"><?= $e($c['nom']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <a href="index.php?page=admin-formation-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une formation</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Formation</th><th>Niveau</th><th>Durée</th><th>Mode</th><th>Prix</th><th>Début</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <?php if (empty($formations)): ?>
                      <tr><td colspan="8" class="text-muted">Aucune formation pour le moment.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($formations as $f): ?>
                    <tr data-categorie="<?= $e($f['categorie']) ?>">
                      <td class="text-muted"><?= (int) $f['id_formation'] ?></td>
                      <td class="min-width"><strong><?= $e($f['titre']) ?></strong><br><small class="text-muted"><?= $e($f['categorie']) ?></small></td>
                      <td><span class="status-btn <?= $niveaux[$f['niveau']][1] ?? '' ?>"><?= $e($niveaux[$f['niveau']][0] ?? $f['niveau']) ?></span></td>
                      <td class="nowrap"><?= (int) $f['duree_heures'] ?> h</td>
                      <td><?= $e($modes[$f['mode']] ?? $f['mode']) ?></td>
                      <td class="nowrap"><strong><?= (float) $f['prix'] == 0 ? 'Gratuite' : $e(rtrim(rtrim(number_format((float) $f['prix'], 2, '.', ''), '0'), '.')) . ' TND' ?></strong></td>
                      <td class="nowrap"><?= $f['date_debut'] ? $e(date('d/m/Y', strtotime($f['date_debut']))) : '—' ?></td>
                      <td>
                        <div class="action">
                          <a href="index.php?page=admin-formation-form&amp;id=<?= (int) $f['id_formation'] ?>" class="main-btn light-btn btn-sm">Modifier</a>
                          <form method="post" action="index.php?page=admin-formations" style="display:inline">
                            <input type="hidden" name="delete_id" value="<?= (int) $f['id_formation'] ?>">
                            <button type="submit" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button>
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
          <!-- ========== tables-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->

      <script>
        // Recherche + filtre par catégorie, côté navigateur
        var champ = document.getElementById('admin-formations-search');
        var filtre = document.getElementById('admin-formations-filtre');
        function filtrer() {
          var q = champ.value.toLowerCase();
          document.querySelectorAll('.table tbody tr[data-categorie]').forEach(function (tr) {
            var okTexte = tr.textContent.toLowerCase().indexOf(q) !== -1;
            var okCat = filtre.value === '' || tr.getAttribute('data-categorie') === filtre.value;
            tr.style.display = (okTexte && okCat) ? '' : 'none';
          });
        }
        champ.addEventListener('input', filtrer);
        filtre.addEventListener('change', filtrer);
      </script>
