      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Traiter un litige</h2>
                <p>Consultez le litige, puis enregistrez la décision de l'administration</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-litiges">Litiges</a></li><li class="breadcrumb-item active" aria-current="page">Traiter un litige</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row-grid cols-wide mb-30">
            <!-- ========== détails du litige ========== -->
            <div class="card-style">
              <div class="card-head"><h3>Litige n° 1</h3><span class="status-btn">En cours</span></div>
              <div class="list-row"><div><strong>Motif</strong><small>Livraison en retard</small></div></div>
              <div class="list-row"><div><strong>Description</strong><small>Les publications ne sont pas en ligne après 3 jours.</small></div></div>
              <div class="list-row"><div><strong>Ouvert par</strong><small>Nour Gharbi (client) · 16/11/2026</small></div></div>
              <div class="list-row"><div><strong>Mission</strong><small>Créer la page Facebook d'une pâtisserie · étudiant : Omar Mansour</small></div></div>
              <div class="list-row"><div><strong>Paiement</strong><small>120 TND · carte · bloqué</small></div></div>
            </div>

            <!-- ========== formulaire de décision ========== -->
            <form class="card-style" action="#" method="post">
              <div class="card-head"><h3>Décision</h3></div>
              <div class="form-grid" style="grid-template-columns:1fr">
                <div class="input-style">
                  <label for="statut">Statut du litige</label>
                  <select id="statut" name="statut" required>
                    <option value="ouvert">Ouvert</option>
                    <option value="en_cours" selected>En cours</option>
                    <option value="resolu">Résolu</option>
                  </select>
                </div>
                <div class="input-style">
                  <label for="paiement">Que faire du paiement ?</label>
                  <select id="paiement" name="statut_paiement">
                    <option value="bloque">Le laisser bloqué</option>
                    <option value="libere">Le verser à l'étudiant</option>
                    <option value="rembourse">Rembourser le client</option>
                  </select>
                </div>
                <div class="input-style">
                  <label for="decision">Décision</label>
                  <textarea id="decision" name="decision" placeholder="Expliquez la décision prise et sa raison"></textarea>
                </div>
                <label class="check"><input type="checkbox" name="suspendre" /> Suspendre aussi le compte responsable</label>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer la décision</button>
                <a href="index.php?page=admin-litiges" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
