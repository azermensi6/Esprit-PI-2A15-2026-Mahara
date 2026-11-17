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
