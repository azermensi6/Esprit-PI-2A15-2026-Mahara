<?php
// $currentPage est fourni par le Controller (voir app/Controllers/Controller.php)
$currentPage = $currentPage ?? 'dashboard';

// Un lien par module : il reste actif sur toutes les pages (listes et formulaires) du module
$modules = [
    ['label' => 'Utilisateurs',               'href' => 'admin-utilisateurs',         'pages' => ['admin-utilisateurs', 'admin-utilisateur-form'], 'count' => 8],
    ['label' => 'Compétences et réalisations', 'href' => 'admin-competences',          'pages' => ['admin-competences', 'admin-competence-form', 'admin-realisations', 'admin-realisation-form'], 'count' => null],
    ['label' => 'Catégories et missions',      'href' => 'admin-missions',             'pages' => ['admin-categories', 'admin-categorie-form', 'admin-missions', 'admin-mission-form'], 'count' => 5],
    ['label' => 'Entreprises',                 'href' => 'admin-entreprises',          'pages' => ['admin-entreprises', 'admin-entreprise-form'], 'count' => 2],
    ['label' => 'Paiements',                   'href' => 'admin-paiements',            'pages' => ['admin-paiements', 'admin-paiement-form'], 'count' => null],
    ['label' => 'Formations',                  'href' => 'admin-formations',           'pages' => ['admin-categories-formation', 'admin-categorie-formation-form', 'admin-formations', 'admin-formation-form'], 'count' => null],
];
$pagesModules = array_merge(...array_column($modules, 'pages'));
$pagesTemplate = ['blank-page', 'signin'];
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
              class="<?= isCollapsed($pagesModules, $currentPage) ?>"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_1"
              aria-controls="ddmenu_1"
              aria-expanded="<?= groupIsExpanded($pagesModules, $currentPage) ?>"
              aria-label="Ouvrir le menu Modules"
            >
              <svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg><span class="text">Modules</span>
            </a>
            <ul id="ddmenu_1" class="collapse <?= isOpen($pagesModules, $currentPage) ?> dropdown-nav">
<?php foreach ($modules as $m): ?>
              <li><a href="index.php?page=<?= $m['href'] ?>" class="<?= in_array($currentPage, $m['pages'], true) ? 'active' : '' ?>"><span class="text"><?= $m['label'] ?></span><?php if ($m['count']): ?><span class="count"><?= $m['count'] ?></span><?php endif; ?></a></li>
<?php endforeach; ?>
            </ul>
          </li>

          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              class="<?= isCollapsed($pagesTemplate, $currentPage) ?>"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_2"
              aria-controls="ddmenu_2"
              aria-expanded="<?= groupIsExpanded($pagesTemplate, $currentPage) ?>"
              aria-label="Ouvrir le menu Pages"
            >
              <svg class="icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4"/></svg><span class="text">Pages du template</span>
            </a>
            <ul id="ddmenu_2" class="collapse <?= isOpen($pagesTemplate, $currentPage) ?> dropdown-nav">
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
