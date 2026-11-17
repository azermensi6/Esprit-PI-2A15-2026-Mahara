      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Litiges</h2>
                <p>Litiges ouverts entre étudiants et clients · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Litiges</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-litiges" class="main-btn btn-sm primary-btn">Litiges</a>
                <a href="index.php?page=admin-suspensions" class="main-btn btn-sm light-btn">Suspensions</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="l-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="l-search" type="search" class="form-control" placeholder="Rechercher un litige" style="width:260px;max-width:100%" />
                  <label for="l-statut" style="position:absolute;left:-9999px">Statut</label>
                  <select id="l-statut" class="form-control" style="width:auto"><option>Tous les statuts</option><option>Ouvert</option><option>En cours</option><option>Résolu</option></select>
                </div>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Motif et mission</th><th>Ouvert par</th><th>Montant bloqué</th><th>Date</th><th>Statut</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Livraison en retard</strong><br><small class="text-muted">Créer la page Facebook d'une pâtisserie</small></td>
                      <td>Nour Gharbi (client)</td>
                      <td class="nowrap"><strong>120 TND</strong></td>
                      <td class="nowrap">16/11/2026</td>
                      <td><span class="status-btn ">En cours</span></td>
                      <td><div class="action"><a href="index.php?page=admin-litige-form" class="main-btn orange-btn btn-sm">Traiter</a><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Suspendre</a></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Travail jugé incomplet</strong><br><small class="text-muted">Site vitrine pour une agence</small></td>
                      <td>Agence Digitale Sfax (client)</td>
                      <td class="nowrap"><strong>350 TND</strong></td>
                      <td class="nowrap">15/11/2026</td>
                      <td><span class="status-btn warning-btn">Ouvert</span></td>
                      <td><div class="action"><a href="index.php?page=admin-litige-form" class="main-btn orange-btn btn-sm">Traiter</a><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Suspendre</a></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Paiement non libéré</strong><br><small class="text-muted">Logo pour une boutique de vêtements</small></td>
                      <td>Omar Mansour (étudiant)</td>
                      <td class="nowrap"><strong>90 TND</strong></td>
                      <td class="nowrap">14/11/2026</td>
                      <td><span class="status-btn warning-btn">Ouvert</span></td>
                      <td><div class="action"><a href="index.php?page=admin-litige-form" class="main-btn orange-btn btn-sm">Traiter</a><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Suspendre</a></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Mauvaise qualité des traductions</strong><br><small class="text-muted">Traduire une plaquette</small></td>
                      <td>Karim Ben Salah (client)</td>
                      <td class="nowrap"><strong>80 TND</strong></td>
                      <td class="nowrap">02/11/2026</td>
                      <td><span class="status-btn success-btn">Résolu</span></td>
                      <td><div class="action"><a href="index.php?page=admin-litige-form" class="main-btn orange-btn btn-sm">Traiter</a><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Suspendre</a></div></td>
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
