/* =====================================================================
   MAHARA · Validation des formulaires côté navigateur (JavaScript)
   ---------------------------------------------------------------------
   - Mêmes règles que la validation PHP des contrôleurs (le PHP reste
     la vraie protection : le JavaScript peut être désactivé ou contourné).
   - Fichier externe (et non <script> dans la page) : la Content-Security-Policy
     définie dans index.php bloque les scripts écrits directement dans le HTML.
   - Chaque message s'affiche dans l'élément [data-erreur="nom_du_champ"] du formulaire.
   Le même fichier est utilisé par le front office et le back office.
   ===================================================================== */
(function () {
  'use strict';

  var NOM   = /^\p{L}[\p{L}\p{N} '.&-]{1,49}$/u;   // 2 à 50 caractères, commence par une lettre
  var EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  var TEL   = /^[0-9]{8}$/;

  /**
   * Branche une validation sur le formulaire #id.
   * regles(val, brut, erreur, form) : val() lit un champ sans les espaces autour,
   * brut() le lit tel quel (mots de passe), erreur(champ, message) affiche le message ('' = pas d'erreur).
   */
  function valider(id, regles) {
    var form = document.getElementById(id);
    if (!form) return;

    form.addEventListener('submit', function (ev) {
      var ok = true;
      function champ(nom) { return form.elements[nom]; }
      function brut(nom) { var el = champ(nom); return el ? el.value : ''; }
      function val(nom) { return brut(nom).trim(); }
      function erreur(nom, message) {
        var zone = form.querySelector('[data-erreur="' + nom + '"]');
        if (zone) zone.textContent = message;
        if (message) ok = false;
      }

      regles(val, brut, erreur, form);

      if (!ok) {
        ev.preventDefault();   // on bloque l'envoi tant qu'il reste des erreurs
        var premiere = form.querySelector('[data-erreur]:not(:empty)');
        if (premiere) premiere.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  }

  function longueur(texte, min, max) { return texte.length >= min && texte.length <= max; }

  /* ---------- Connexion (front et back office) ---------- */
  valider('form-connexion', function (val, brut, erreur) {
    erreur('email', EMAIL.test(val('email')) ? '' : 'Saisis une adresse email valide.');
    erreur('mot_de_passe', brut('mot_de_passe') !== '' ? '' : 'Saisis ton mot de passe.');
  });

  /* ---------- Inscription ---------- */
  valider('form-inscription', function (val, brut, erreur, form) {
    var min = parseInt(form.dataset.mdpMin || '8', 10);
    erreur('nom', NOM.test(val('nom')) ? '' : 'Le nom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('prenom', NOM.test(val('prenom')) ? '' : 'Le prénom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('email', EMAIL.test(val('email')) ? '' : 'Adresse email invalide.');
    var tel = val('telephone').replace(/\s/g, '');
    erreur('telephone', tel === '' || TEL.test(tel) ? '' : 'Le téléphone doit contenir exactement 8 chiffres.');
    erreur('mot_de_passe', brut('mot_de_passe').length >= min ? '' : 'Le mot de passe doit contenir au moins ' + min + ' caractères.');
    erreur('confirmation', brut('mot_de_passe') === brut('confirmation') ? '' : 'Les mots de passe ne correspondent pas.');
  });

  /* ---------- Profil (front office) ---------- */
  valider('form-profil', function (val, brut, erreur, form) {
    var min = parseInt(form.dataset.mdpMin || '8', 10);
    erreur('nom', NOM.test(val('nom')) ? '' : 'Le nom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('prenom', NOM.test(val('prenom')) ? '' : 'Le prénom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('email', EMAIL.test(val('email')) ? '' : 'Adresse email invalide.');
    var tel = val('telephone').replace(/\s/g, '');
    erreur('telephone', tel === '' || TEL.test(tel) ? '' : 'Le téléphone doit contenir exactement 8 chiffres.');

    var actuel = brut('mot_de_passe_actuel'), mdp = brut('mot_de_passe');
    var change = actuel !== '' || mdp !== '';
    erreur('mot_de_passe_actuel', change && actuel === '' ? 'Saisis ton mot de passe actuel.' : '');
    erreur('mot_de_passe', change && mdp.length < min ? 'Le nouveau mot de passe doit contenir au moins ' + min + ' caractères.' : '');
    erreur('confirmation', change && mdp !== brut('confirmation') ? 'Les mots de passe ne correspondent pas.' : '');
  });

  /* ---------- Utilisateur (back office) ---------- */
  valider('form-utilisateur', function (val, brut, erreur, form) {
    var ajout = form.dataset.mode === 'ajout';
    var min = parseInt(form.dataset.mdpMin || '8', 10);
    erreur('nom', NOM.test(val('nom')) ? '' : 'Le nom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('prenom', NOM.test(val('prenom')) ? '' : 'Le prénom doit contenir 2 à 50 caractères et commencer par une lettre.');
    erreur('email', EMAIL.test(val('email')) ? '' : 'Adresse email invalide.');
    var tel = val('telephone').replace(/\s/g, '');
    erreur('telephone', tel === '' || TEL.test(tel) ? '' : 'Le téléphone doit contenir exactement 8 chiffres.');
    if (!form.elements.role.disabled) {
      erreur('role', val('role') !== '' ? '' : 'Choisissez un rôle.');
    }
    var mdp = brut('mot_de_passe');
    erreur('mot_de_passe', ajout && mdp === '' ? 'Le mot de passe est obligatoire.'
                         : (mdp !== '' && mdp.length < min) ? 'Le mot de passe doit contenir au moins ' + min + ' caractères.' : '');
    erreur('confirmation', mdp === brut('confirmation') ? '' : 'Les mots de passe ne correspondent pas.');
  });

  /* ---------- Réclamation (front office) ---------- */
  valider('form-reclamation', function (val, brut, erreur) {
    erreur('sujet', longueur(val('sujet'), 5, 150) ? '' : 'Le sujet doit contenir entre 5 et 150 caractères.');
    erreur('type_probleme', val('type_probleme') !== '' ? '' : 'Choisissez le module concerné.');
    erreur('description', longueur(val('description'), 20, 2000) ? '' : 'La description doit contenir entre 20 et 2000 caractères.');
  });

  /* ---------- Traitement d'une réclamation (back office) ---------- */
  valider('form-traitement', function (val, brut, erreur) {
    var cloture = val('statut') === 'resolue' || val('statut') === 'rejetee';
    var reponse = val('reponse');
    erreur('reponse', cloture && reponse.length < 10 ? 'Une réponse d\'au moins 10 caractères est obligatoire pour clôturer la réclamation.'
                    : reponse.length > 2000 ? 'La réponse ne doit pas dépasser 2000 caractères.' : '');
  });

  /* ---------- Entreprise (front office « Mon entreprise » et back office) ---------- */
  var VILLE = /^\p{L}[\p{L} '-]{1,59}$/u;   // 2 à 60 lettres
  var URL   = /^https?:\/\/[^\s.]+\.[^\s]+$/i;

  valider('form-entreprise', function (val, brut, erreur, form) {
    erreur('nom', longueur(val('nom'), 2, 100) ? '' : 'Le nom doit contenir entre 2 et 100 caractères.');
    var secteur = val('secteur');
    erreur('secteur', secteur === '' || longueur(secteur, 2, 60) ? '' : 'Le secteur doit contenir entre 2 et 60 caractères.');
    var ville = val('ville');
    erreur('ville', ville === '' || VILLE.test(ville) ? '' : 'La ville doit contenir entre 2 et 60 lettres.');
    var site = val('site_web');
    erreur('site_web', site === '' || (URL.test(site) && site.length <= 255) ? '' : 'Le site web doit être une adresse valide commençant par http:// ou https://');
    if (form.elements.id_recruteur) {
      erreur('id_recruteur', val('id_recruteur') !== '' ? '' : 'Choisissez un recruteur.');
    }
  });

  /* ---------- Offre d'emploi (front office « Publier une offre » et back office) ---------- */
  valider('form-offre', function (val, brut, erreur, form) {
    erreur('titre', longueur(val('titre'), 5, 120) ? '' : 'L\'intitulé doit contenir entre 5 et 120 caractères.');
    erreur('type_offre', val('type_offre') !== '' ? '' : 'Choisissez le type d\'offre.');
    if (form.elements.id_entreprise) {
      erreur('id_entreprise', val('id_entreprise') !== '' ? '' : 'Choisissez l\'entreprise qui propose l\'offre.');
    }
    var ville = val('ville');
    erreur('ville', ville === '' || VILLE.test(ville) ? '' : 'La ville doit contenir entre 2 et 60 lettres.');
    var salaire = val('salaire');
    erreur('salaire', salaire === '' || (!isNaN(salaire) && Number(salaire) >= 0 && Number(salaire) <= 50000) ? '' : 'Le salaire doit être un nombre entre 0 et 50000 TND (vide si à négocier).');
    var limite = val('date_limite'), min = form.dataset.minDate || '';
    erreur('date_limite', limite === '' || limite >= min ? '' : 'La date limite ne peut pas être avant le ' + min.split('-').reverse().join('/') + '.');
    erreur('description', longueur(val('description'), 20, 3000) ? '' : 'La description doit contenir entre 20 et 3000 caractères.');
  });

  /* ---------- Compteur de caractères (réclamation, offre d'emploi) ---------- */
  var texte = document.querySelector('[data-compteur]');
  if (texte) {
    var compteur = document.getElementById(texte.dataset.compteur);
    var maj = function () { compteur.textContent = texte.value.trim().length; };
    texte.addEventListener('input', maj);
    maj();
  }

  /* ---------- Listes déroulantes de filtre : envoi automatique du formulaire ---------- */
  document.querySelectorAll('.js-autosubmit').forEach(function (select) {
    select.addEventListener('change', function () { select.form.submit(); });
  });

})();
