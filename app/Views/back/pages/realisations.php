      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Réalisations</h2>
                <p>Réalisations publiées dans les portfolios · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Réalisations</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-competences" class="main-btn btn-sm light-btn">Compétences</a>
                <a href="index.php?page=admin-realisations" class="main-btn btn-sm primary-btn">Réalisations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-realisations-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-realisations-search" type="search" class="form-control" placeholder="Rechercher une réalisation" style="width:260px;max-width:100%" />
                  <label for="admin-realisations-filtre" style="position:absolute;left:-9999px">Filtrer</label>
                  <select id="admin-realisations-filtre" class="form-control" style="width:auto"><option>Toutes les compétences</option><option>Design graphique</option><option>Développement web</option><option>Réseaux sociaux</option><option>Traduction</option></select>
                </div>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Réalisation</th><th>Étudiant</th><th>Compétence</th><th>Date</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Logo pour un club universitaire</strong><br><small class="text-muted">Logo et charte couleurs</small></td>
                      <td>Yasmine Ben Ali</td>
                      <td>Design graphique</td>
                      <td class="nowrap">10/03/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-realisation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Affiche de la journée des métiers</strong><br><small class="text-muted">Affiche A3 imprimée</small></td>
                      <td>Yasmine Ben Ali</td>
                      <td>Design graphique</td>
                      <td class="nowrap">02/05/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-realisation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Site vitrine d'un café</strong><br><small class="text-muted">Site en HTML/CSS/PHP</small></td>
                      <td>Mehdi Trabelsi</td>
                      <td>Développement web</td>
                      <td class="nowrap">15/06/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-realisation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Page Instagram d'une boutique</strong><br><small class="text-muted">30 publications en un mois</small></td>
                      <td>Omar Mansour</td>
                      <td>Réseaux sociaux</td>
                      <td class="nowrap">01/09/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-realisation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">5</td>
                      <td class="min-width"><strong>Traduction d'un menu de restaurant</strong><br><small class="text-muted">Français vers anglais</small></td>
                      <td>Omar Mansour</td>
                      <td>Traduction</td>
                      <td class="nowrap">12/10/2026</td>
                      <td><div class="action"><a href="index.php?page=admin-realisation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette réalisation ?">Supprimer</button></div></td>
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
