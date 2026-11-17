<?php require_once __DIR__ . '/../partials/head.php'; ?>
    <!-- ========== signin start ========== -->
    <section class="signin-wrapper">
      <div class="signin-side">
        <div class="navbar-logo" style="align-self:flex-start">
          <a href="index.php?page=dashboard">
            <img src="app/Views/back/assets/images/logo/logo-icone.png" alt="" />
            <span class="brand"><strong>MAHARA</strong><small>BACK OFFICE</small></span>
          </a>
        </div>
        <div>
          <h1>Espace administration</h1>
          <p>Validez les comptes, modérez les missions et traitez les litiges de la plateforme.</p>
        </div>
        <p style="font-size:14px">&copy; 2026 Mahara</p>
      </div>
      <div class="signin-form">
        <form action="index.php?page=dashboard" method="post">
          <h2>Connexion</h2>
          <p class="text-muted">Réservé aux administrateurs.</p>
          <div class="input-style">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="admin@mahara.tn" required />
          </div>
          <div class="input-style">
            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mot_de_passe" type="password" required />
          </div>
          <label class="check"><input type="checkbox" name="souvenir" /> Se souvenir de moi</label>
          <button type="submit" class="main-btn orange-btn" style="width:100%">Se connecter</button>
        </form>
      </div>
    </section>
    <!-- ========== signin end ========== -->
<?php require_once __DIR__ . '/../partials/scripts.php'; ?>
