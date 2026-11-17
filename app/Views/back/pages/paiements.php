      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Paiements</h2>
                <p>Paiements des candidatures acceptées : bloqués, puis libérés ou remboursés · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Paiements</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-paiements-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-paiements-search" type="search" class="form-control" placeholder="Rechercher une mission" style="width:260px;max-width:100%" />
                  <label for="admin-paiements-filtre" style="position:absolute;left:-9999px">Filtrer</label>
                  <select id="admin-paiements-filtre" class="form-control" style="width:auto"><option>Tous les états</option><option>Bloqué</option><option>Libéré</option><option>Remboursé</option></select>
                </div>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Candidature (mission)</th><th>Montant</th><th>Mode</th><th>Date</th><th>État</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Créer la page Facebook d'une pâtisserie</strong><br><small class="text-muted">Nour Gharbi → Omar Mansour</small></td>
                      <td class="nowrap"><strong>120 TND</strong></td>
                      <td>Carte</td>
                      <td class="nowrap">09/11/2026</td>
                      <td><span class="status-btn warning-btn">Bloqué</span></td>
                      <td><div class="action"><a href="index.php?page=admin-paiement-form" class="main-btn light-btn btn-sm">Modifier</a></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Logo pour une pâtisserie</strong><br><small class="text-muted">Nour Gharbi → Yasmine Ben Ali</small></td>
                      <td class="nowrap"><strong>90 TND</strong></td>
                      <td>Virement</td>
                      <td class="nowrap">22/10/2026</td>
                      <td><span class="status-btn success-btn">Libéré</span></td>
                      <td><div class="action"><a href="index.php?page=admin-paiement-form" class="main-btn light-btn btn-sm">Modifier</a></div></td>
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
