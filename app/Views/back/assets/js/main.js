/* =====================================================================
   MAHARA · Template Back Office · scripts communs
   ===================================================================== */
(function () {
  'use strict';

  // 1. Preloader : caché quand la page est chargée
  window.addEventListener('load', function () {
    var preloader = document.getElementById('preloader');
    if (preloader) preloader.classList.add('hide');
  });

  // 2. Sidebar mobile : ouvrir avec le bouton, fermer avec l'overlay
  var sidebar = document.querySelector('.sidebar-nav-wrapper');
  var overlay = document.querySelector('.overlay');
  var toggle = document.querySelector('.menu-toggle-btn');
  function setSidebar(open) {
    if (!sidebar) return;
    sidebar.classList.toggle('active', open);
    if (overlay) overlay.classList.toggle('active', open);
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  if (toggle) toggle.addEventListener('click', function () { setSidebar(!sidebar.classList.contains('active')); });
  if (overlay) overlay.addEventListener('click', function () { setSidebar(false); });

  // 3. Sous-menus de la sidebar (attribut data-bs-toggle="collapse")
  document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var target = document.querySelector(link.getAttribute('data-bs-target'));
      if (!target) return;
      var open = target.classList.toggle('show');
      link.classList.toggle('collapsed', !open);
      link.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  // 4. Boutons « Supprimer » : demande de confirmation
  document.querySelectorAll('[data-confirm]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      if (!window.confirm(btn.getAttribute('data-confirm'))) e.preventDefault();
    });
  });
})();
