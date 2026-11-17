      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Modifier un paiement</h2>
                <p>Changer l'état d'un paiement (libérer ou rembourser)</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-paiements">Paiements</a></li><li class="breadcrumb-item active" aria-current="page">Modifier un paiement</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style full">
                  <label for="candidature">Candidature</label>
                  <select id="candidature" name="id_candidature" required><option value="">Choisir…</option><option value="1" selected>Omar Mansour · Créer la page Facebook d'une pâtisserie</option><option value="3">Yasmine Ben Ali · Logo pour une pâtisserie</option></select>
                </div>
                <div class="input-style">
                  <label for="montant">Montant (TND)</label>
                  <input id="montant" name="montant" type="number" value="120" required min="0" step="0.5" />
                </div>
                <div class="input-style">
                  <label for="mode">Mode de paiement</label>
                  <select id="mode" name="mode_paiement"><option value="carte" selected>Carte</option><option value="virement">Virement</option><option value="especes">Espèces</option></select>
                </div>
                <div class="input-style full">
                  <label for="statut">État</label>
                  <select id="statut" name="statut"><option value="bloque" selected>Bloqué</option><option value="libere">Libéré (versé à l'étudiant)</option><option value="rembourse">Remboursé (au client)</option></select>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-paiements" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
