/* Module P3 · Recrutement — applique le thème choisi (clair / sombre) AVANT l'affichage
 * de la page, pour éviter un éclair blanc. Chargé dans <head> ; le bouton qui change le
 * thème est ajouté dans l'en-tête de la page par recrutement.js. */
(function () {
  'use strict';
  var theme = null;
  try {
    theme = window.localStorage.getItem('mahara-theme');
    window.localStorage.removeItem('mahara-zoom');      // ancien réglage de zoom, retiré
  } catch (e) { /* stockage bloqué : thème clair */ }
  if (theme === 'sombre') { document.documentElement.setAttribute('data-theme', 'sombre'); }
})();
