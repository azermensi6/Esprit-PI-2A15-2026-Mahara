      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Entreprises</h2>
                <p>Entreprises des recruteurs, à vérifier avant publication de leurs offres · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Entreprises</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-entreprises-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-entreprises-search" type="search" class="form-control" placeholder="Rechercher une entreprise" style="width:260px;max-width:100%" />
                  <label for="admin-entreprises-filtre" style="position:absolute;left:-9999px">Filtrer</label>
                  <select id="admin-entreprises-filtre" class="form-control" style="width:auto"><option>Tous les statuts</option><option>En attente</option><option>Vérifiée</option><option>Refusée</option></select>
                </div>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Entreprise</th><th>Recruteur</th><th>Secteur</th><th>Ville</th><th>Offres</th><th>Statut</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Agence Digitale Sfax</strong><br><small class="text-muted">digitalsfax.tn</small></td>
                      <td>Amel Jaziri</td>
                      <td>Marketing digital</td>
                      <td class="nowrap">Sfax</td>
                      <td>3</td>
                      <td><span class="status-btn success-btn">Vérifiée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-entreprise-form" class="main-btn light-btn btn-sm">Détails</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Marquer cette entreprise comme vérifiée ?">Vérifier</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Refuser cette entreprise ?">Refuser</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Start-up Ariana</strong><br><small class="text-muted">startup-ariana.tn</small></td>
                      <td>Hichem Bouazizi</td>
                      <td>Logiciels</td>
                      <td class="nowrap">Ariana</td>
                      <td>1</td>
                      <td><span class="status-btn warning-btn">En attente</span></td>
                      <td><div class="action"><a href="index.php?page=admin-entreprise-form" class="main-btn light-btn btn-sm">Détails</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Marquer cette entreprise comme vérifiée ?">Vérifier</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Refuser cette entreprise ?">Refuser</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Cabinet Conseil Sousse</strong><br><small class="text-muted">—</small></td>
                      <td>Rim Hammami</td>
                      <td>Conseil</td>
                      <td class="nowrap">Sousse</td>
                      <td>0</td>
                      <td><span class="status-btn danger-btn">Refusée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-entreprise-form" class="main-btn light-btn btn-sm">Détails</a><button type="button" class="main-btn primary-btn btn-sm" data-confirm="Marquer cette entreprise comme vérifiée ?">Vérifier</button><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Refuser cette entreprise ?">Refuser</button></div></td>
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
