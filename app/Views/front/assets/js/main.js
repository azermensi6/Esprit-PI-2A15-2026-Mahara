/* =====================================================================
   MAHARA · Template Front Office · scripts communs
   ===================================================================== */
(function () {
  'use strict';

  // 1. Spinner : on le cache quand la page est chargée
  window.addEventListener('load', function () {
    var spinner = document.getElementById('spinner');
    if (spinner) spinner.classList.add('hide');
  });

  // 2. Menu mobile : ouvrir / fermer
  var toggler = document.querySelector('.navbar-toggler');
  var collapse = document.querySelector('.navbar-collapse');
  if (toggler && collapse) {
    toggler.addEventListener('click', function () {
      var open = collapse.classList.toggle('open');
      toggler.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    // Fermer le menu mobile après un clic sur un lien
    collapse.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        collapse.classList.remove('open');
        toggler.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // 2b. Accueil : surligner dans la navbar la section visible à l'écran
  var sectionLinks = document.querySelectorAll('.navbar-nav a.nav-link[href^="#"]');
  if (sectionLinks.length && 'IntersectionObserver' in window) {
    var linkFor = {};
    sectionLinks.forEach(function (link) { linkFor[link.getAttribute('href').slice(1)] = link; });
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        sectionLinks.forEach(function (l) { l.classList.remove('active'); });
        var link = linkFor[entry.target.id];
        if (link) link.classList.add('active');
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    Object.keys(linkFor).forEach(function (id) {
      var section = document.getElementById(id);
      if (section) observer.observe(section);
    });
  }

  // 3. Bouton « retour en haut »
  var backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      backToTop.classList.toggle('show', window.scrollY > 300);
    });
    backToTop.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 3b. Boutons « Supprimer », « Retirer »… : demander confirmation
  document.querySelectorAll('[data-confirm]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      if (!window.confirm(btn.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  // 4. Inscription : carte du type de compte sélectionnée
  var options = document.querySelectorAll('.role-option');
  options.forEach(function (option) {
    var input = option.querySelector('input[type="radio"]');
    if (!input) return;
    input.addEventListener('change', function () {
      options.forEach(function (o) { o.classList.remove('selected'); });
      option.classList.add('selected');
      var label = document.getElementById('form-role-label');
      if (label) label.textContent = option.dataset.label || '';
    });
  });
})();
