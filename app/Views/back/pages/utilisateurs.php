      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Utilisateurs</h2>
                <p>Valider les nouveaux comptes et suspendre les comptes abusifs · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Utilisateurs</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-utilisateurs-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-utilisateurs-search" type="search" class="form-control" placeholder="Rechercher un nom ou un email" style="width:260px;max-width:100%" />
                  <label for="admin-utilisateurs-filtre" style="position:absolute;left:-9999px">Filtrer</label>
                  <select id="admin-utilisateurs-filtre" class="form-control" style="width:auto"><option>Tous les rôles</option><option>Étudiant</option><option>Client</option><option>Recruteur</option><option>Admin</option></select>
                </div>
                <a href="index.php?page=admin-utilisateur-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter un utilisateur</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Utilisateur</th><th>Rôle</th><th>Statut</th><th>Inscription</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Mahara Admin</strong><br><small class="text-muted">admin@mahara.tn</small></td>
                      <td><span class="status-btn success-btn">Admin</span></td>
                      <td><span class="status-btn success-btn">Actif</span></td>
                      <td class="nowrap">01/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Yasmine Ben Ali</strong><br><small class="text-muted">yasmine.benali@etu.utm.tn</small></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td><span class="status-btn success-btn">Actif</span></td>
                      <td class="nowrap">03/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Mehdi Trabelsi</strong><br><small class="text-muted">mehdi.trabelsi@etu.uss.tn</small></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td><span class="status-btn success-btn">Actif</span></td>
                      <td class="nowrap">05/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Sarra Kefi</strong><br><small class="text-muted">sarra.kefi@etu.ucar.tn</small></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td><span class="status-btn danger-btn">Suspendu</span></td>
                      <td class="nowrap">06/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">5</td>
                      <td class="min-width"><strong>Nour Gharbi</strong><br><small class="text-muted">contact@patisserie-nour.tn</small></td>
                      <td><span class="status-btn light-btn">Client</span></td>
                      <td><span class="status-btn success-btn">Actif</span></td>
                      <td class="nowrap">10/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">6</td>
                      <td class="min-width"><strong>Karim Ben Salah</strong><br><small class="text-muted">karim@cabinet-bensalah.tn</small></td>
                      <td><span class="status-btn light-btn">Client</span></td>
                      <td><span class="status-btn success-btn">Actif</span></td>
                      <td class="nowrap">12/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">7</td>
                      <td class="min-width"><strong>Amel Jaziri</strong><br><small class="text-muted">rh@digitalsfax.tn</small></td>
                      <td><span class="status-btn ">Recruteur</span></td>
                      <td><span class="status-btn warning-btn">En attente</span></td>
                      <td class="nowrap">15/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">8</td>
                      <td class="min-width"><strong>Omar Mansour</strong><br><small class="text-muted">omar.mansour@etu.utm.tn</small></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td><span class="status-btn danger-btn">Suspendu</span></td>
                      <td class="nowrap">18/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-utilisateur-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Valider ce compte ?">Valider</button><button type="button" class="main-btn light-btn btn-sm" data-confirm="Suspendre ce compte ?">Suspendre</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer ce compte ?">Supprimer</button></div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- ========== tables-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
