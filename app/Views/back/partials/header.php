      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="header-left">
            <button type="button" class="menu-toggle-btn" aria-label="Ouvrir le menu" aria-expanded="false"><svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/></svg></button>
            <form class="header-search" action="#" data-no-submit>
              <svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6"/><path d="M15 15l6 6"/></svg>
              <label for="header-search" style="position:absolute;left:-9999px">Rechercher</label>
              <input id="header-search" type="search" placeholder="Rechercher un utilisateur, une mission" />
            </form>
          </div>
          <div class="header-right">
            <button type="button" class="header-icon-btn" aria-label="Notifications"><svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4z"/><path d="M10 20a2 2 0 0 0 4 0"/></svg><span class="dot"></span></button>
            <button type="button" class="header-icon-btn hide-sm" aria-label="Messages"><svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></button>
            <div class="profile-box">
<?php $admin = currentUser(); ?>
              <div class="avatar"><?= e(mb_strtoupper(mb_substr($admin['prenom'] ?? 'A', 0, 1) . mb_substr($admin['nom'] ?? 'D', 0, 1))) ?></div>
              <div class="info"><strong><?= e(trim(($admin['prenom'] ?? '') . ' ' . ($admin['nom'] ?? ''))) ?: 'Administrateur' ?></strong><a href="index.php?page=deconnexion">Se déconnecter</a></div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->
