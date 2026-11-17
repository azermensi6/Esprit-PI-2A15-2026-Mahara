      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Catégories de formation</h2>
                <p>Catégories des formations proposées aux étudiants · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item active" aria-current="page">Catégories de formation</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== tables-wrapper start ========== -->
          <div class="tables-wrapper">
            <div class="card-style mb-30">
              <div class="left" style="margin-bottom:16px">
                <a href="index.php?page=admin-categories-formation" class="main-btn btn-sm primary-btn">Catégories</a>
                <a href="index.php?page=admin-formations" class="main-btn btn-sm light-btn">Formations</a>
              </div>
              <div class="table-toolbar">
                <div class="left">
                  <label for="admin-categories-formation-search" style="position:absolute;left:-9999px">Rechercher</label>
                  <input id="admin-categories-formation-search" type="search" class="form-control" placeholder="Rechercher une catégorie" style="width:260px;max-width:100%" />
                </div>
                <a href="index.php?page=admin-categorie-formation-form" class="main-btn orange-btn"><svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Ajouter une catégorie</a>
              </div>
              <div class="table-wrapper">
                <table class="table">
                  <thead>
                    <tr><th>#</th><th>Catégorie</th><th>Description</th><th>Formations</th><th style="text-align:right">Actions</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-muted">1</td>
                      <td class="min-width"><strong>Design</strong></td>
                      <td>Outils et bases du design graphique</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-categorie-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette catégorie ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">2</td>
                      <td class="min-width"><strong>Développement web</strong></td>
                      <td>HTML, CSS, JavaScript, PHP</td>
                      <td>2</td>
                      <td><div class="action"><a href="index.php?page=admin-categorie-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette catégorie ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">3</td>
                      <td class="min-width"><strong>Marketing digital</strong></td>
                      <td>Réseaux sociaux et communication</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-categorie-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette catégorie ?">Supprimer</button></div></td>
                    </tr>
                    <tr>
                      <td class="text-muted">4</td>
                      <td class="min-width"><strong>Langues</strong></td>
                      <td>Anglais et français professionnels</td>
                      <td>1</td>
                      <td><div class="action"><a href="index.php?page=admin-categorie-formation-form" class="main-btn light-btn btn-sm">Modifier</a><button type="button" class="main-btn danger-btn-outline btn-sm" data-confirm="Supprimer cette catégorie ?">Supprimer</button></div></td>
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
