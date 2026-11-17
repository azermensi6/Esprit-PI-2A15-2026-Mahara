      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Missions</h2>
                <p>Missions publiées par les clients · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Missions</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-categories" class="main-btn btn-sm light-btn">Catégories</a>
                <a href="index.php?page=admin-missions" class="main-btn btn-sm primary-btn">Missions</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="t-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="t-search" type="search" class="form-control" placeholder="Rechercher une mission" style="width:260px;max-width:100%" />
                  <label for="t-statut" style="position:absolute;left:-9999px">Statut</label>
                  <select id="t-statut" class="form-control" style="width:auto"><option>Tous les statuts</option><option>Ouverte</option><option>En cours</option><option>Terminée</option><option>Annulée</option></select>
                </div>
                <a href="index.php?page=admin-mission-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une mission</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Titre</th><th>Catégorie</th><th>Client</th><th>Budget</th><th>Ville</th><th>Statut</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Créer la page Facebook d'une pâtisserie</strong></td>
                      <td>Réseaux sociaux</td>
                      <td>Nour Gharbi</td>
                      <td class="nowrap"><strong>120 TND</strong></td>
                      <td class="nowrap">La Marsa</td>
                      <td><span class="status-btn ">En cours</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Logo pour une pâtisserie</strong></td>
                      <td>Design</td>
                      <td>Nour Gharbi</td>
                      <td class="nowrap"><strong>90 TND</strong></td>
                      <td class="nowrap">La Marsa</td>
                      <td><span class="status-btn success-btn">Terminée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Site vitrine pour un cabinet</strong></td>
                      <td>Développement web</td>
                      <td>Karim Ben Salah</td>
                      <td class="nowrap"><strong>600 TND</strong></td>
                      <td class="nowrap">Tunis</td>
                      <td><span class="status-btn light-btn">Ouverte</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Traduire une plaquette</strong></td>
                      <td>Traduction</td>
                      <td>Karim Ben Salah</td>
                      <td class="nowrap"><strong>80 TND</strong></td>
                      <td class="nowrap">Tunis</td>
                      <td><span class="status-btn light-btn">Ouverte</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">5</td>
                      <td class="min-width"><strong>Logo pour une boutique de vêtements</strong></td>
                      <td>Design</td>
                      <td>Boutique Nour</td>
                      <td class="nowrap"><strong>90 TND</strong></td>
                      <td class="nowrap">Sousse</td>
                      <td><span class="status-btn warning-btn">Signalée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">6</td>
                      <td class="min-width"><strong>Soutien en maths pour un élève de 9e</strong></td>
                      <td>Cours particuliers</td>
                      <td>Leila Saidi</td>
                      <td class="nowrap"><strong>60 TND</strong></td>
                      <td class="nowrap">Ariana</td>
                      <td><span class="status-btn danger-btn">Annulée</span></td>
                      <td><div class="action"><a href="index.php?page=admin-mission-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette mission ?">Supprimer</button></div></td>
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
