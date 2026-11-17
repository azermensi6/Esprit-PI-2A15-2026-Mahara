      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Compétences</h2>
                <p>Compétences proposées aux étudiants · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Compétences</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-competences" class="main-btn btn-sm primary-btn">Compétences</a>
                <a href="index.php?page=admin-realisations" class="main-btn btn-sm light-btn">Réalisations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-competences-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-competences-search" type="search" class="form-control" placeholder="Rechercher une compétence" style="width:260px;max-width:100%" />
                </div>
                <a href="index.php?page=admin-competence-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une compétence</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Compétence</th><th>Description</th><th>Réalisations</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Design graphique</strong></td>
                      <td>Logos, affiches, identité visuelle</td>
                      <td>2</td>
                      <td><div class="action"><a href="index.php?page=admin-competence-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette compétence ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Développement web</strong></td>
                      <td>Sites vitrines, HTML, CSS, PHP</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-competence-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette compétence ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Réseaux sociaux</strong></td>
                      <td>Création et animation de pages</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-competence-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette compétence ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Traduction</strong></td>
                      <td>Arabe, français, anglais</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-competence-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette compétence ?">Supprimer</button></div></td>
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
