      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Ajouter une formation</h2>
                <p>Ajout et modification d'une formation</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-formations">Formations</a></li><li class="breadcrumb-item active" aria-current="page">Ajouter une formation</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Titre</label>
                  <input id="titre" name="titre" type="text" placeholder="Ex. PHP et MySQL pour débutants" required maxlength="150" />
                </div>
                <div class="input-style">
                  <label for="categorie">Catégorie</label>
                  <select id="categorie" name="id_categorie_formation" required><option value="">Choisir…</option><option value="1">Design</option><option value="2">Développement web</option><option value="3">Marketing digital</option><option value="4">Langues</option></select>
                </div>
                <div class="input-style">
                  <label for="niveau">Niveau</label>
                  <select id="niveau" name="niveau"><option value="debutant" selected>Débutant</option><option value="intermediaire">Intermédiaire</option><option value="avance">Avancé</option></select>
                </div>
                <div class="input-style">
                  <label for="duree">Durée (heures)</label>
                  <input id="duree" name="duree_heures" type="number" required min="1" />
                </div>
                <div class="input-style">
                  <label for="mode">Mode</label>
                  <select id="mode" name="mode"><option value="en_ligne" selected>En ligne</option><option value="presentiel">Présentiel</option><option value="hybride">Hybride</option></select>
                </div>
                <div class="input-style">
                  <label for="prix">Prix (TND)</label>
                  <input id="prix" name="prix" type="number" value="0" required min="0" step="0.5" />
                </div>
                <div class="input-style">
                  <label for="debut">Date de début</label>
                  <input id="debut" name="date_debut" type="date" />
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"></textarea>
                  <small>Le programme, les prérequis et ce que l'étudiant saura faire à la fin.</small>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-formations" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
