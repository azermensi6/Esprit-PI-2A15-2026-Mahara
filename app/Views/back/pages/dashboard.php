      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30 mb-30">
            <div class="row">
              <div>
                <h2>Tableau de bord</h2>
                <p>Vue d'ensemble de la plateforme · données d'exemple</p>
              </div>
              <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item active" aria-current="page">Tableau de bord</li></ol></nav>
            </div>
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row-grid cols-4 mb-30">
            <div class="card-style icon-card"><div class="label">Étudiants inscrits</div><div class="value ">1 248</div><div class="trend ">+86 ce mois</div></div>
            <div class="card-style icon-card"><div class="label">Clients et recruteurs</div><div class="value ">312</div><div class="trend ">+24 ce mois</div></div>
            <div class="card-style icon-card"><div class="label">Missions en cours</div><div class="value ">74</div><div class="trend neutral">196 terminées</div></div>
            <div class="card-style icon-card"><div class="label">Volume payé</div><div class="value blue">18 450 TND</div><div class="trend ">+12 % par rapport au mois dernier</div></div>
          </div>

          <div class="row-grid cols-wide mb-30">
            <div class="card-style">
              <div class="card-head"><h3>Comptes à valider</h3><a href="index.php?page=admin-missions">Voir les 12</a></div>
              <div class="table-wrapper">
                <table class="table">
                  <thead><tr><th>Nom</th><th>Type</th><th>Justificatif</th><th style="text-align:right">Action</th></tr></thead>
                  <tbody>
                    <tr>
                      <td class="min-width"><strong>Yasmine B.</strong></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td class="text-muted">Email universitaire vérifié</td>
                      <td><div class="action"><button type="button" class="main-btn primary-btn btn-sm">Valider</button><button type="button" class="main-btn light-btn btn-sm">Refuser</button></div></td>
                    </tr>
                    <tr>
                      <td class="min-width"><strong>Mehdi T.</strong></td>
                      <td><span class="status-btn warning-btn">Étudiant</span></td>
                      <td class="text-muted">Carte étudiant à vérifier</td>
                      <td><div class="action"><button type="button" class="main-btn primary-btn btn-sm">Valider</button><button type="button" class="main-btn light-btn btn-sm">Refuser</button></div></td>
                    </tr>
                    <tr>
                      <td class="min-width"><strong>Agence Digitale Sfax</strong></td>
                      <td><span class="status-btn ">Recruteur</span></td>
                      <td class="text-muted">Registre de commerce à vérifier</td>
                      <td><div class="action"><button type="button" class="main-btn primary-btn btn-sm">Valider</button><button type="button" class="main-btn light-btn btn-sm">Refuser</button></div></td>
                    </tr>
                    <tr>
                      <td class="min-width"><strong>Pâtisserie La Marsa</strong></td>
                      <td><span class="status-btn light-btn">Client</span></td>
                      <td class="text-muted">Téléphone vérifié</td>
                      <td><div class="action"><button type="button" class="main-btn primary-btn btn-sm">Valider</button><button type="button" class="main-btn light-btn btn-sm">Refuser</button></div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-style">
              <div class="card-head"><h3>Missions par catégorie</h3></div>
              <div class="bars">
              <div class="bar-row"><span>Design</span><div class="bar-track"><div class="bar-fill" style="width:100%"></div></div><span class="num">82</span></div>
              <div class="bar-row"><span>Développement web</span><div class="bar-track"><div class="bar-fill" style="width:78%"></div></div><span class="num">64</span></div>
              <div class="bar-row"><span>Réseaux sociaux</span><div class="bar-track"><div class="bar-fill" style="width:66%"></div></div><span class="num">54</span></div>
              <div class="bar-row"><span>Traduction</span><div class="bar-track"><div class="bar-fill" style="width:46%"></div></div><span class="num">38</span></div>
              <div class="bar-row"><span>Cours particuliers</span><div class="bar-track"><div class="bar-fill" style="width:39%"></div></div><span class="num">32</span></div>
              </div>
              <p class="text-muted" style="margin-top:14px;font-size:13px;font-weight:600">270 missions publiées depuis le lancement.</p>
            </div>
          </div>

          <div class="row-grid cols-2 mb-30">
            <div class="card-style">
              <div class="card-head"><h3>Missions à modérer</h3><a href="index.php?page=admin-missions">Voir les 5</a></div>
              <div class="list-row"><div><strong>Logo pour une boutique de vêtements</strong><small>Client : Boutique Nour · 90 TND · Sousse</small></div><span class="status-btn warning-btn">Budget trop bas</span></div>
              <div class="list-row"><div><strong>Site vitrine pour un cabinet</strong><small>Client : Cabinet Ben Salah · 600 TND · Tunis</small></div><span class="status-btn">Nouvelle</span></div>
              <div class="list-row"><div><strong>Rédaction de 10 fiches produit</strong><small>Client : Épicerie Bio Ariana · 150 TND · Ariana</small></div><span class="status-btn warning-btn">Signalée</span></div>
            </div>
            <div class="card-style">
              <div class="card-head"><h3>Litiges ouverts</h3><a href="index.php?page=admin-missions">Voir les 3</a></div>
              <div class="list-row"><div><strong>Livraison en retard</strong><small>Amine K. et Restaurant El Medina · 200 TND bloqués</small></div><a href="index.php?page=admin-mission-form" class="main-btn orange-btn btn-sm">Traiter</a></div>
              <div class="list-row"><div><strong>Travail jugé incomplet</strong><small>Sarra M. et Agence Digitale Sfax · 350 TND bloqués</small></div><a href="index.php?page=admin-mission-form" class="main-btn orange-btn btn-sm">Traiter</a></div>
              <div class="list-row"><div><strong>Paiement non libéré</strong><small>Omar J. et Boutique Nour · 90 TND bloqués</small></div><a href="index.php?page=admin-mission-form" class="main-btn orange-btn btn-sm">Traiter</a></div>
            </div>
          </div>
        </div>
      </section>
      <!-- ========== section end ========== -->
