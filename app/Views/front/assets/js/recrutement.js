/* =====================================================================
 * Module P3 · Recrutement — confort et accessibilité (front office)
 *   1. Bouton « Mode sombre / Mode clair » dans l'en-tête de la page
 *   2. Onde au clic sur les boutons
 *   3. Impression / enregistrement PDF d'une offre (window.print + feuille d'impression)
 *   4. Recherche vocale des offres (Web Speech API : SpeechRecognition)
 * Fichier séparé, aucun script dans les pages : respect de la Content-Security-Policy.
 * Le choix du thème est gardé dans le navigateur (localStorage) et appliqué
 * dès l'ouverture de la page par recrutement-theme.js.
 * ===================================================================== */
(function () {
  'use strict';

  var racine = document.documentElement;
  var ecrire = function (cle, valeur) { try { window.localStorage.setItem(cle, valeur); } catch (e) { /* stockage bloqué */ } };

  /* ---------- 1. Bouton « Mode sombre / Mode clair » dans l'en-tête de la page ---------- */
  var ICONE_LUNE   = '<svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>';
  var ICONE_SOLEIL = '<svg class="icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>';
  // Placé à droite du fil d'Ariane (« Accueil / Offres d'emploi »), dans le bandeau du template.
  var filAriane = document.querySelector('.page-header .breadcrumb');
  if (filAriane) {
    var boutonTheme = document.createElement('button');
    boutonTheme.type = 'button';
    boutonTheme.className = 'btn btn-outline btn-sm btn-theme-nav';
    var majTheme = function () {
      var sombre = racine.getAttribute('data-theme') === 'sombre';
      boutonTheme.innerHTML = (sombre ? ICONE_SOLEIL : ICONE_LUNE) + '<span>' + (sombre ? 'Mode clair' : 'Mode sombre') + '</span>';
      boutonTheme.setAttribute('aria-pressed', sombre ? 'true' : 'false');
      boutonTheme.title = sombre ? 'Revenir au mode clair' : 'Baisser la lumière (mode sombre)';
    };
    boutonTheme.addEventListener('click', function () {
      var sombre = racine.getAttribute('data-theme') !== 'sombre';
      if (sombre) { racine.setAttribute('data-theme', 'sombre'); } else { racine.removeAttribute('data-theme'); }
      ecrire('mahara-theme', sombre ? 'sombre' : 'clair');
      majTheme();
    });
    majTheme();
    var ligne = document.createElement('div');
    ligne.className = 'ligne-entete';
    filAriane.parentNode.insertBefore(ligne, filAriane);
    ligne.appendChild(filAriane);
    ligne.appendChild(boutonTheme);
  }

  /* ---------- 2. Onde au clic sur les boutons ---------- */
  var animationsReduites = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!animationsReduites) {
    document.addEventListener('pointerdown', function (e) {
      var bouton = e.target.closest ? e.target.closest('.btn') : null;
      if (!bouton) { return; }
      var zone = bouton.getBoundingClientRect();
      var taille = Math.max(zone.width, zone.height);
      var onde = document.createElement('span');
      onde.className = 'onde';
      onde.style.width = onde.style.height = taille + 'px';
      onde.style.left = (e.clientX - zone.left - taille / 2) + 'px';
      onde.style.top = (e.clientY - zone.top - taille / 2) + 'px';
      bouton.appendChild(onde);
      setTimeout(function () { onde.remove(); }, 600);
    });
  }

  /* ---------- 3. Impression / PDF ---------- */
  document.querySelectorAll('[data-imprimer]').forEach(function (bouton) {
    bouton.addEventListener('click', function () { window.print(); });
  });

  /* ---------- 4. Recherche vocale (Chrome et Edge ; bouton caché ailleurs) ---------- */
  var Reconnaissance = window.SpeechRecognition || window.webkitSpeechRecognition;
  if (!Reconnaissance) { return; }

  // Minuscules et sans accents, pour comparer « Sfax » et « sfax », « Médenine » et « medenine »
  var normaliser = function (texte) {
    return texte.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').trim();
  };
  var MOTS_VIDES = ['je', 'cherche', 'recherche', 'un', 'une', 'des', 'de', 'du', 'a', 'au', 'en', 'dans', 'pour', 'offre', 'offres', 'poste'];

  document.querySelectorAll('[data-micro]').forEach(function (bouton) {
    var champ = document.getElementById(bouton.dataset.micro);
    if (!champ || !champ.form) { return; }
    var form   = champ.form;
    var statut = form.querySelector('.statut-micro');
    var dire   = function (message) { if (statut) { statut.textContent = message; } };
    bouton.hidden = false;

    bouton.addEventListener('click', function () {
      var reco = new Reconnaissance();
      reco.lang = 'fr-FR';
      reco.interimResults = false;
      reco.maxAlternatives = 1;

      reco.onstart = function () { bouton.classList.add('ecoute'); dire('Parle maintenant… (ex. « stage à Sfax »)'); };
      reco.onend   = function () { bouton.classList.remove('ecoute'); };
      reco.onerror = function (e) {
        dire(e.error === 'not-allowed' ? 'Autorise le micro dans ton navigateur pour utiliser la recherche vocale.'
                                       : 'Je n\'ai pas compris, réessaie.');
      };

      reco.onresult = function (e) {
        var phrase = e.results[0][0].transcript.replace(/[.!?]+$/, '');
        var reste  = normaliser(phrase);
        dire('« ' + phrase + ' »');

        // « stage » ou « emploi » dans la phrase → coche le type d'offre
        form.querySelectorAll('input[name="type"]').forEach(function (radio) {
          if (radio.value !== '' && new RegExp('\\b' + radio.value + 's?\\b').test(reste)) {
            radio.checked = true;
            reste = reste.replace(new RegExp('\\b' + radio.value + 's?\\b'), ' ');
          }
        });

        // Un nom de ville de la liste → choisit la ville
        var ville = form.querySelector('select[name="ville"]');
        if (ville) {
          Array.prototype.forEach.call(ville.options, function (option) {
            var nom = normaliser(option.value);
            if (nom !== '' && reste.indexOf(nom) !== -1) {
              ville.value = option.value;
              reste = reste.replace(nom, ' ');
            }
          });
        }

        // « accessible » → coche le filtre des postes accessibles
        var accessible = form.querySelector('input[name="accessible"]');
        if (accessible && /\baccessibles?\b|\bhandicap/.test(reste)) {
          accessible.checked = true;
          reste = reste.replace(/\baccessibles?\b|\bhandicap\w*/g, ' ');
        }

        // Le reste de la phrase devient le mot-clé
        champ.value = reste.split(/\s+/).filter(function (mot) {
          return mot !== '' && MOTS_VIDES.indexOf(mot) === -1;
        }).join(' ');

        form.submit();
      };

      reco.start();
    });
  });

  /* ---------- 5. Logo de l'entreprise : aperçu de l'image choisie avant l'envoi ---------- */
  var champLogo = document.getElementById('logo');
  var apercuLogo = document.querySelector('[data-apercu-logo]');
  if (champLogo && apercuLogo && window.FileReader) {
    var apercuInitial = apercuLogo.innerHTML;
    champLogo.addEventListener('change', function () {
      var fichier = champLogo.files && champLogo.files[0];
      if (!fichier || !/^image\/(png|jpeg|webp)$/.test(fichier.type)) { apercuLogo.innerHTML = apercuInitial; return; }
      var lecteur = new FileReader();
      lecteur.onload = function () {
        var img = document.createElement('img');
        img.className = 'logo-ent';
        img.alt = 'Aperçu du logo';
        img.width = 72; img.height = 72;
        img.style.cssText = 'width:72px;height:72px;border-radius:50%;object-fit:cover;background:#fff';
        img.src = lecteur.result;                // image locale (data:), autorisée par la CSP
        apercuLogo.innerHTML = '';
        apercuLogo.appendChild(img);
      };
      lecteur.readAsDataURL(fichier);
    });
  }
})();
