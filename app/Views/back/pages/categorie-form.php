      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Ajouter une catégorie</h2>
                <p>Ajout et modification d'une catégorie de missions</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-categories">Catégories</a></li><li class="breadcrumb-item active" aria-current="page">Ajouter une catégorie</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="nom">Nom de la catégorie</label>
                  <input id="nom" name="nom" type="text" placeholder="Ex. Cours particuliers" required />
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"></textarea>
                  <small>Affichée aux clients quand ils choisissent une catégorie.</small>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-categories" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
