<?php
// $currentPage est fourni par le Controller (voir app/Controllers/Controller.php)
$currentPage = $currentPage ?? 'dashboard';
?>
    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
        <a href="index.php?page=dashboard">
          <img src="app/Views/back/assets/images/logo/logo-icone.png" alt="" />
          <span class="brand"><strong>MAHARA</strong><small>BACK OFFICE</small></span>
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item <?= isActive('dashboard', $currentPage) ?>">
            <a href="index.php?page=dashboard"><svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/></svg><span class="text">Tableau de bord</span></a>
          </li>

          <li class="nav-title">Gestion</li>
          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="<?= isCollapsed(['admin-missions'], $currentPage) ?>"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_1"
              aria-controls="ddmenu_1"
              aria-expanded="<?= groupIsExpanded(['admin-missions'], $currentPage) ?>"
              aria-label="Ouvrir le menu Modules"
            >
              <svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg><span class="text">Modules</span>
            </a>
            <ul id="ddmenu_1" class="collapse <?= isOpen(['admin-missions'], $currentPage) ?> dropdown-nav">
              <!-- Chaque membre remplace son # par index.php?page=... quand sa page est prête -->
              <li><a href="#"><span class="text">Utilisateurs</span></a></li>
              <li><a href="#"><span class="text">Compétences et réalisations</span></a></li>
              <li><a href="index.php?page=admin-missions" class="<?= isActive('admin-missions', $currentPage) ?>"><span class="text">Catégories et missions</span><span class="count">5</span></a></li>
              <li><a href="#"><span class="text">Entreprises et offres</span></a></li>
              <li><a href="#"><span class="text">Candidatures et paiements</span></a></li>
              <li><a href="#"><span class="text">Litiges et suspensions</span><span class="count">3</span></a></li>
            </ul>
          </li>

          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="<?= isCollapsed(['admin-missions', 'admin-mission-form', 'blank-page', 'signin'], $currentPage) ?>"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_2"
              aria-controls="ddmenu_2"
              aria-expanded="<?= groupIsExpanded(['admin-missions', 'admin-mission-form', 'blank-page', 'signin'], $currentPage) ?>"
              aria-label="Ouvrir le menu Pages"
            >
              <svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/></svg><span class="text">Pages du template</span>
            </a>
            <ul id="ddmenu_2" class="collapse <?= isOpen(['admin-missions', 'admin-mission-form', 'blank-page', 'signin'], $currentPage) ?> dropdown-nav">
              <li><a href="index.php?page=admin-missions" class="<?= isActive('admin-missions', $currentPage) ?>">Missions (liste)</a></li>
              <li><a href="index.php?page=admin-mission-form" class="<?= isActive('admin-mission-form', $currentPage) ?>">Ajouter une mission</a></li>
              <li><a href="index.php?page=blank-page" class="<?= isActive('blank-page', $currentPage) ?>">Page vide</a></li>
              <li><a href="index.php?page=signin" class="<?= isActive('signin', $currentPage) ?>">Connexion admin</a></li>
            </ul>
          </li>

          <span class="divider"></span>
          <li class="nav-item">
            <a href="index.php?page=accueil"><svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18"/><path d="M12 3a14 14 0 0 0 0 18"/></svg><span class="text">Voir le site</span></a>
          </li>
        </ul>
      </nav>
    </aside>
    <!-- ======== sidebar-nav end =========== -->
