      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Vérifier une entreprise</h2>
                <p>Contrôlez les informations saisies par le recruteur, puis donnez votre décision</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-entreprises">Entreprises</a></li><li class="breadcrumb-item active" aria-current="page">Vérifier une entreprise</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row-grid cols-wide mb-30">
            <!-- ========== informations de l'entreprise ========== -->
            <div class="card-style">
              <div class="card-head"><h3>Start-up Ariana</h3><span class="status-btn warning-btn">En attente</span></div>
              <div class="list-row"><div><strong>Recruteur</strong><small>Hichem Bouazizi · rh@startup-ariana.tn</small></div></div>
              <div class="list-row"><div><strong>Secteur</strong><small>Logiciels</small></div></div>
              <div class="list-row"><div><strong>Ville</strong><small>Ariana</small></div></div>
              <div class="list-row"><div><strong>Site web</strong><small>https://startup-ariana.tn</small></div></div>
              <div class="list-row"><div><strong>Offres publiées</strong><small>Assistant marketing digital (emploi)</small></div></div>
            </div>

            <!-- ========== décision ========== -->
            <form class="card-style" action="#" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
              <div class="card-head"><h3>Décision</h3></div>
              <div class="form-grid" style="grid-template-columns:1fr">
                <div class="input-style">
                  <label for="statut">Statut de l'entreprise</label>
                  <select id="statut" name="statut" required>
                    <option value="en_attente" selected>En attente</option>
                    <option value="verifiee">Vérifiée</option>
                    <option value="refusee">Refusée</option>
                  </select>
                  <small>Seules les entreprises vérifiées apparaissent dans les offres d'emploi.</small>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-entreprises" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
