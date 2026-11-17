      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Ajouter une mission</h2>
                <p>Ajout et modification d'une mission</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-missions">Missions</a></li><li class="breadcrumb-item active" aria-current="page">Ajouter une mission</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="titre">Titre</label>
                  <input id="titre" name="titre" type="text" placeholder="Ex. Créer la page Facebook d'une pâtisserie" required />
                </div>
                <div class="input-style">
                  <label for="categorie">Catégorie</label>
                  <select id="categorie" name="id_categorie" required>
                    <option value="">Choisir…</option><option>Design</option><option>Développement web</option><option>Réseaux sociaux</option><option>Traduction</option><option>Cours particuliers</option>
                  </select>
                </div>
                <div class="input-style">
                  <label for="client">Client</label>
                  <select id="client" name="id_client" required>
                    <option value="">Choisir…</option><option>Nour Gharbi</option><option>Karim Ben Salah</option>
                  </select>
                </div>
                <div class="input-style">
                  <label for="budget">Budget (TND)</label>
                  <input id="budget" name="budget" type="number" min="0" step="0.5" required />
                </div>
                <div class="input-style">
                  <label for="delai">Délai (jours)</label>
                  <input id="delai" name="delai_jours" type="number" min="1" required />
                </div>
                <div class="input-style">
                  <label for="ville">Ville</label>
                  <input id="ville" name="ville" type="text" />
                </div>
                <div class="input-style">
                  <label for="statut">Statut</label>
                  <select id="statut" name="statut"><option value="ouverte">Ouverte</option><option value="en_cours">En cours</option><option value="terminee">Terminée</option><option value="annulee">Annulée</option></select>
                </div>
                <div class="input-style full">
                  <label for="description">Description</label>
                  <textarea id="description" name="description"></textarea>
                  <small>Décrivez le besoin du client en quelques phrases.</small>
                </div>
                <div class="full">
                  <label class="check"><input type="checkbox" name="mise_en_avant" /> Mettre la mission en avant sur l'accueil</label>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-missions" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
