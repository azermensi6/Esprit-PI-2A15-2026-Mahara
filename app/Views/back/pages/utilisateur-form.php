      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Modifier un utilisateur</h2>
                <p>Informations du compte · le statut permet de valider ou de suspendre le compte</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php?page=dashboard">Tableau de bord</a></li><li class="breadcrumb-item"><a href="index.php?page=admin-utilisateurs">Utilisateurs</a></li><li class="breadcrumb-item active" aria-current="page">Modifier un utilisateur</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <form class="card-style mb-30" action="#" method="post">
              <div class="form-grid">
                <div class="input-style">
                  <label for="nom">Nom</label>
                  <input id="nom" name="nom" type="text" value="Jaziri" required />
                </div>
                <div class="input-style">
                  <label for="prenom">Prénom</label>
                  <input id="prenom" name="prenom" type="text" value="Amel" required />
                </div>
                <div class="input-style">
                  <label for="email">Email</label>
                  <input id="email" name="email" type="email" value="rh@digitalsfax.tn" required />
                </div>
                <div class="input-style">
                  <label for="telephone">Téléphone</label>
                  <input id="telephone" name="telephone" type="tel" value="74666777" />
                </div>
                <div class="input-style">
                  <label for="role">Rôle</label>
                  <select id="role" name="role" required><option value="">Choisir…</option><option value="etudiant">Étudiant</option><option value="client">Client</option><option value="recruteur" selected>Recruteur</option><option value="admin">Administrateur</option></select>
                </div>
                <div class="input-style">
                  <label for="statut">Statut du compte</label>
                  <select id="statut" name="statut"><option value="en_attente" selected>En attente de validation</option><option value="actif">Actif</option><option value="suspendu">Suspendu</option></select>
                </div>
                <div class="input-style full">
                  <label for="mdp">Nouveau mot de passe</label>
                  <input id="mdp" name="mot_de_passe" type="password" placeholder="Laisser vide pour ne pas le changer" />
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="main-btn orange-btn">Enregistrer</button>
                <a href="index.php?page=admin-utilisateurs" class="main-btn light-btn">Annuler</a>
              </div>
            </form>
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
      </section>
      <!-- ========== section end ========== -->
