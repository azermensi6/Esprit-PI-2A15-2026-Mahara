      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Ajouter une suspension</h2>
                <p>Suspendre un compte, avec ou sans litige lié</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-suspensions">Suspensions</a></li><li class="breadcrumb-item active" aria-current="page">Ajouter une suspension</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style">
                  <label for="utilisateur">Compte à suspendre</label>
                  <select id="utilisateur" name="id_utilisateur" required>
                    <option value="">Choisir…</option>
                    <option>Omar Mansour (étudiant)</option>
                    <option>Sarra Kefi (étudiant)</option>
                    <option>Boutique Nour (client)</option>
                  </select>
                </div>
                <div class="input-style">
                  <label for="litige">Litige lié</label>
                  <select id="litige" name="id_litige">
                    <option value="">Aucun litige</option>
                    <option>N° 1 · Livraison en retard</option>
                    <option>N° 2 · Travail jugé incomplet</option>
                    <option>N° 3 · Paiement non libéré</option>
                  </select>
                  <small>Optionnel : une suspension peut exister sans litige.</small>
                </div>
                <div class="input-style">
                  <label for="date_debut">Date de début</label>
                  <input id="date_debut" name="date_debut" type="date" required />
                </div>
                <div class="input-style">
                  <label for="date_fin">Date de fin</label>
                  <input id="date_fin" name="date_fin" type="date" />
                  <small>Laissez vide pour une suspension définitive.</small>
                </div>
                <div class="input-style full">
                  <label for="motif">Motif</label>
                  <textarea id="motif" name="motif" required placeholder="Ex. Retard répété sans prévenir le client"></textarea>
                </div>
                <div class="full">
                  <label class="check"><input type="checkbox" name="notifier" checked /> Prévenir l'utilisateur par email</label>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer la suspension</button>
                <a href="index.php?page=admin-suspensions" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
