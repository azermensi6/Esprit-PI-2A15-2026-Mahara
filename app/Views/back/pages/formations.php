      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Formations</h2>
                <p>Formations proposées aux étudiants · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Formations</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

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
                  <select id="admin-formations-filtre" class="form-control" style="width:auto"><option>Toutes les catégories</option><option>Design</option><option>Développement web</option><option>Marketing digital</option><option>Langues</option></select>
                </div>
                <a href="index.php?page=admin-formation-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une formation</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Formation</th><th>Niveau</th><th>Durée</th><th>Mode</th><th>Prix</th><th>Début</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Initiation à Canva et Figma</strong><br><small class="text-muted">Design</small></td>
                      <td><span class="status-btn success-btn">Débutant</span></td>
                      <td class="nowrap">12 h</td>
                      <td>En ligne</td>
                      <td class="nowrap"><strong>Gratuite</strong></td>
                      <td class="nowrap">01/12/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>PHP et MySQL pour débutants</strong><br><small class="text-muted">Développement web</small></td>
                      <td><span class="status-btn success-btn">Débutant</span></td>
                      <td class="nowrap">30 h</td>
                      <td>Hybride</td>
                      <td class="nowrap"><strong>60 TND</strong></td>
                      <td class="nowrap">05/12/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>JavaScript moderne</strong><br><small class="text-muted">Développement web</small></td>
                      <td><span class="status-btn warning-btn">Intermédiaire</span></td>
                      <td class="nowrap">24 h</td>
                      <td>En ligne</td>
                      <td class="nowrap"><strong>45 TND</strong></td>
                      <td class="nowrap">10/01/2027</td>
                      <td><div class="action"><a href="index.php?page=admin-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Gérer la page Facebook d'un commerce</strong><br><small class="text-muted">Marketing digital</small></td>
                      <td><span class="status-btn success-btn">Débutant</span></td>
                      <td class="nowrap">8 h</td>
                      <td>Présentiel</td>
                      <td class="nowrap"><strong>30 TND</strong></td>
                      <td class="nowrap">12/12/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">5</td>
                      <td class="min-width"><strong>Anglais professionnel</strong><br><small class="text-muted">Langues</small></td>
                      <td><span class="status-btn warning-btn">Intermédiaire</span></td>
                      <td class="nowrap">20 h</td>
                      <td>En ligne</td>
                      <td class="nowrap"><strong>40 TND</strong></td>
                      <td class="nowrap">15/01/2027</td>
                      <td><div class="action"><a href="index.php?page=admin-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette formation ?">Supprimer</button></div></td>
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
