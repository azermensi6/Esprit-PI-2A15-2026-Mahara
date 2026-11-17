      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Suspensions</h2>
                <p>Comptes suspendus, avec ou sans litige · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Suspensions</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-litiges" class="main-btn btn-sm light-btn">Litiges</a>
                <a href="index.php?page=admin-suspensions" class="main-btn btn-sm primary-btn">Suspensions</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="s-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="s-search" type="search" class="form-control" placeholder="Rechercher un utilisateur" style="width:260px;max-width:100%" />
                  <label for="s-etat" style="position:absolute;left:-9999px">État</label>
                  <select id="s-etat" class="form-control" style="width:auto"><option>Toutes</option><option>Actives</option><option>Terminées</option></select>
                </div>
                <a href="index.php?page=admin-suspension-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une suspension</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Utilisateur</th><th>Motif</th><th>Début</th><th>Fin</th><th>Litige lié</th><th>État</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Omar Mansour</strong><br><small class="text-muted">Étudiant</small></td>
                      <td class="min-width">Retard répété sans prévenir le client</td>
                      <td class="nowrap">16/11/2026</td>
                      <td class="nowrap">30/11/2026</td>
                      <td>Livraison en retard</td>
                      <td><span class="status-btn danger-btn">Active</span></td>
                      <td><div class="action"><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Lever cette suspension ?">Lever</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Sarra Kefi</strong><br><small class="text-muted">Étudiant</small></td>
                      <td class="min-width">Faux justificatif étudiant</td>
                      <td class="nowrap">17/11/2026</td>
                      <td class="nowrap">Définitive</td>
                      <td>—</td>
                      <td><span class="status-btn danger-btn">Active</span></td>
                      <td><div class="action"><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Lever cette suspension ?">Lever</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Boutique Nour</strong><br><small class="text-muted">Client</small></td>
                      <td class="min-width">Missions publiées avec un budget abusif</td>
                      <td class="nowrap">01/10/2026</td>
                      <td class="nowrap">15/10/2026</td>
                      <td>—</td>
                      <td><span class="status-btn light-btn">Terminée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-suspension-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Lever cette suspension ?">Lever</button></div></td>
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
