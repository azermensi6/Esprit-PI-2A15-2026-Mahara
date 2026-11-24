<?php
/**
 * Vue : connexion au back office (page sans layout).
 * Reçoit : $errors (string[]), $email, $csrfToken
 */
require_once __DIR__ . '/../partials/head.php';
?>
    <!-- ========== signin start ========== -->
    <section class="signin-wrapper">
      <div class="signin-side">
        <div class="navbar-logo" style="align-self:flex-start">
          <a href="index.php?page=accueil">
            <img src="app/Views/back/assets/images/logo/logo-icone.png" alt="" />
            <span class="brand"><strong>MAHARA</strong><small>BACK OFFICE</small></span>
          </a>
        </div>
        <div>
          <h1>Espace administration</h1>
          <p>Validez les comptes, modérez les missions, vérifiez les entreprises, gérez les formations et traitez les réclamations.</p>
        </div>
        <p style="font-size:14px">&copy; 2026 Mahara</p>
      </div>
      <div class="signin-form">
        <form id="form-connexion" action="index.php?page=signin" method="post" novalidate>
          <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
          <h2>Connexion</h2>
          <p class="text-muted">Réservé aux administrateurs.</p>
          <?php if (!empty($errors)): ?>
            <div role="alert" style="background:#fdecec;color:#a61b1b;border-radius:8px;padding:10px 14px;font-weight:600;margin-bottom:12px">
              <?php foreach ($errors as $error): ?><div><?= e($error) ?></div><?php endforeach; ?>
            </div>
          <?php endif; ?>
          <div class="input-style">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" placeholder="admin@mahara.tn" value="<?= e($email ?? '') ?>" />
            <small data-erreur="email" style="color:#d62828"></small>
          </div>
          <div class="input-style">
            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mot_de_passe" type="password" autocomplete="current-password" />
            <small data-erreur="mot_de_passe" style="color:#d62828"></small>
          </div>
          <button type="submit" class="main-btn orange-btn" style="width:100%">Se connecter</button>
        </form>
      </div>
    </section>
    <!-- ========== signin end ========== -->
<?php require_once __DIR__ . '/../partials/scripts.php'; ?>
