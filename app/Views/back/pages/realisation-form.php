      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Modifier une réalisation</h2>
                <p>Modération d'une réalisation de portfolio</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-realisations">Réalisations</a></li><li class="breadcrumb-item active" aria-current="page">Modifier une réalisation</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Titre</label>
                  <input id="titre" name="titre" type="text" value="Logo pour un club universitaire" required />
                </div>
                <div class="input-style">
                  <label for="etudiant">Étudiant</label>
                  <select id="etudiant" name="id_etudiant" required><option value="">Choisir…</option><option value="2" selected>Yasmine Ben Ali</option><option value="3">Mehdi Trabelsi</option><option value="8">Omar Mansour</option></select>
                </div>
                <div class="input-style">
                  <label for="competence">Compétence</label>
                  <select id="competence" name="id_competence" required><option value="">Choisir…</option><option value="1" selected>Design graphique</option><option value="2">Développement web</option><option value="3">Réseaux sociaux</option><option value="4">Traduction</option></select>
                </div>
                <div class="input-style">
                  <label for="date">Date de réalisation</label>
                  <input id="date" name="date_realisation" type="date" value="2026-03-10" />
                </div>
                <div class="input-style">
                  <label for="lien">Lien</label>
                  <input id="lien" name="lien" type="url" value="https://behance.net/exemple1" />
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description">Logo et charte couleurs</textarea>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-realisations" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
