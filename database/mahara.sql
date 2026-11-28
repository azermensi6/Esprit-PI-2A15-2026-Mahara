-- =====================================================================
--  MAHARA : base de données complète (MySQL / MariaDB, phpMyAdmin)
--  2 tables communes (utilisateur, reclamation) + 5 modules de 2 tables chacun
-- =====================================================================

DROP DATABASE IF EXISTS mahara;
CREATE DATABASE mahara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mahara;

-- =====================================================================
--  TABLE COMMUNE (faite par les 5 membres)
-- =====================================================================

CREATE TABLE utilisateur (
    id_utilisateur   INT AUTO_INCREMENT PRIMARY KEY,
    nom              VARCHAR(50)  NOT NULL,
    prenom           VARCHAR(50)  NOT NULL,
    email            VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe     VARCHAR(255) NOT NULL,          -- toujours haché (password_hash en PHP)
    telephone        VARCHAR(20),
    role             ENUM('etudiant','client','recruteur','admin') NOT NULL,
    statut           ENUM('en_attente','actif','suspendu') NOT NULL DEFAULT 'en_attente',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
--  PERSONNE 1 : ESPACE ÉTUDIANT (portfolio)
--  competence  1 ---- N  realisation
-- =====================================================================

CREATE TABLE competence (
    id_competence INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(60) NOT NULL UNIQUE,
    description   VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE realisation (
    id_realisation   INT AUTO_INCREMENT PRIMARY KEY,
    titre            VARCHAR(120) NOT NULL,
    description      TEXT,
    lien             VARCHAR(255),
    date_realisation DATE,
    id_competence    INT NOT NULL,                   -- jointure du module
    id_etudiant      INT NOT NULL,                   -- lien avec utilisateur
    FOREIGN KEY (id_competence) REFERENCES competence(id_competence),
    FOREIGN KEY (id_etudiant)   REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
--  PERSONNE 2 : ESPACE CLIENT (missions)
--  categorie  1 ---- N  mission
-- =====================================================================

CREATE TABLE categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(60) NOT NULL UNIQUE,
    description  VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE mission (
    id_mission       INT AUTO_INCREMENT PRIMARY KEY,
    titre            VARCHAR(120) NOT NULL,
    description      TEXT,
    budget           DECIMAL(10,2) NOT NULL,         -- en dinars (TND)
    delai_jours      INT NOT NULL,
    ville            VARCHAR(60),
    statut           ENUM('ouverte','en_cours','terminee','annulee') NOT NULL DEFAULT 'ouverte',
    date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_categorie     INT NOT NULL,                   -- jointure du module
    id_client        INT NOT NULL,                   -- lien avec utilisateur
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie),
    FOREIGN KEY (id_client)    REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
--  PERSONNE 3 : ESPACE RECRUTEUR
--  entreprise  1 ---- N  offre_emploi
-- =====================================================================

CREATE TABLE entreprise (
    id_entreprise INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    secteur       VARCHAR(60),
    ville         VARCHAR(60),
    site_web      VARCHAR(255),
    logo          VARCHAR(255) NULL,                 -- fichier du logo (uploads/logos), NULL = initiales
    statut        ENUM('en_attente','verifiee','refusee') NOT NULL DEFAULT 'en_attente',  -- vérifiée par l'admin
    id_recruteur  INT NOT NULL,                      -- lien avec utilisateur
    FOREIGN KEY (id_recruteur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE offre_emploi (
    id_offre         INT AUTO_INCREMENT PRIMARY KEY,
    titre            VARCHAR(120) NOT NULL,
    type_offre       ENUM('stage','emploi') NOT NULL,
    description      TEXT,
    ville            VARCHAR(60),
    salaire          DECIMAL(10,2),                  -- par mois, en TND (NULL si non précisé)
    accessible       TINYINT(1) NOT NULL DEFAULT 0,  -- 1 = poste accessible aux personnes en situation de handicap
    date_publication DATE NOT NULL,
    date_limite      DATE,
    id_entreprise    INT NOT NULL,                   -- jointure du module
    FOREIGN KEY (id_entreprise) REFERENCES entreprise(id_entreprise) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
--  PERSONNE 4 : MISSIONS ET PAIEMENT
--  candidature  1 ---- 0,1  paiement
-- =====================================================================

CREATE TABLE candidature (
    id_candidature   INT AUTO_INCREMENT PRIMARY KEY,
    message          TEXT,
    prix_propose     DECIMAL(10,2),
    statut           ENUM('en_attente','acceptee','refusee','livree') NOT NULL DEFAULT 'en_attente',
    date_candidature DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_etudiant      INT NOT NULL,                   -- lien avec utilisateur
    id_mission       INT NOT NULL,                   -- lien avec le module de la personne 2
    FOREIGN KEY (id_etudiant) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_mission)  REFERENCES mission(id_mission) ON DELETE CASCADE,
    UNIQUE (id_etudiant, id_mission)                 -- un étudiant postule une seule fois par mission
) ENGINE=InnoDB;

CREATE TABLE paiement (
    id_paiement    INT AUTO_INCREMENT PRIMARY KEY,
    montant        DECIMAL(10,2) NOT NULL,
    mode_paiement  ENUM('carte','virement','especes') NOT NULL,
    statut         ENUM('bloque','libere','rembourse') NOT NULL DEFAULT 'bloque',
    date_paiement  DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_candidature INT NOT NULL UNIQUE,              -- jointure du module (un paiement par candidature acceptée)
    FOREIGN KEY (id_candidature) REFERENCES candidature(id_candidature)
) ENGINE=InnoDB;

-- =====================================================================
--  PERSONNE 5 : FORMATIONS
--  categorie_formation  1 ---- N  formation
-- =====================================================================

CREATE TABLE categorie_formation (
    id_categorie_formation INT AUTO_INCREMENT PRIMARY KEY,
    nom                    VARCHAR(80)  NOT NULL UNIQUE,
    description            VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE formation (
    id_formation           INT AUTO_INCREMENT PRIMARY KEY,
    titre                  VARCHAR(150) NOT NULL,
    description            TEXT,
    niveau                 ENUM('debutant','intermediaire','avance') NOT NULL DEFAULT 'debutant',
    duree_heures           INT NOT NULL,
    mode                   ENUM('en_ligne','presentiel','hybride') NOT NULL DEFAULT 'en_ligne',
    prix                   DECIMAL(10,2) NOT NULL DEFAULT 0,   -- en dinars (TND), 0 = gratuite
    date_debut             DATE,
    date_creation          DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_categorie_formation INT NOT NULL,                       -- jointure du module
    FOREIGN KEY (id_categorie_formation) REFERENCES categorie_formation(id_categorie_formation)
) ENGINE=InnoDB;

-- =====================================================================
--  TABLE COMMUNE : RÉCLAMATIONS (tous les modules)
--  utilisateur  1 ---- N  reclamation   (« Déposer » : l'auteur)
--  utilisateur  0,1 -- N  reclamation   (« Traiter » : un admin, facultatif)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reclamation (
    id_reclamation   INT AUTO_INCREMENT PRIMARY KEY,
    sujet            VARCHAR(150) NOT NULL,
    description      TEXT         NOT NULL,
    type_probleme    ENUM('compte','portfolio','mission','recrutement','paiement','formation','autre')
                     NOT NULL DEFAULT 'autre',               -- le module concerné
    statut           ENUM('en_attente','en_cours','resolue','rejetee') NOT NULL DEFAULT 'en_attente',
    reponse          TEXT,                                    -- réponse de l'administrateur
    date_reclamation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_traitement  DATETIME,                                -- rempli quand la réclamation est résolue ou rejetée
    id_utilisateur   INT NOT NULL,                            -- jointure : l'auteur
    id_admin         INT NULL,                                -- jointure : l'admin qui traite (NULL = non attribuée)
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_admin)       REFERENCES utilisateur(id_utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;


-- =====================================================================
--  DONNÉES D'EXEMPLE (inventées, pour tester)
-- =====================================================================

-- Les mots de passe ci-dessous sont un faux hachage d'exemple : ces comptes ne peuvent pas se connecter.
-- Pour tester la connexion, créez un compte depuis votre page d'inscription (password_hash en PHP).
-- Seul le compte admin a un vrai mot de passe : admin@mahara.tn / Admin@2026
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role, statut) VALUES
('Admin',     'Mahara', 'admin@mahara.tn',            '$2y$10$v4jNxKh0jFggT/v8ak.kKeGbqGig.ssz6EG2AkDcVbQDcI1bmuFC2', '70000000', 'admin',     'actif'),       -- 1
('Ben Ali',   'Yasmine','yasmine.benali@etu.utm.tn',  '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '22111222', 'etudiant',  'actif'),       -- 2
('Trabelsi',  'Mehdi',  'mehdi.trabelsi@etu.uss.tn',  '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '23222333', 'etudiant',  'actif'),       -- 3
('Kefi',      'Sarra',  'sarra.kefi@etu.ucar.tn',     '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '24333444', 'etudiant',  'suspendu'),    -- 4
('Gharbi',    'Nour',   'contact@patisserie-nour.tn', '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '55444555', 'client',    'actif'),       -- 5
('Ben Salah', 'Karim',  'karim@cabinet-bensalah.tn',  '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '98555666', 'client',    'actif'),       -- 6
('Jaziri',    'Amel',   'rh@digitalsfax.tn',          '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '74666777', 'recruteur', 'actif'),       -- 7
('Mansour',   'Omar',   'omar.mansour@etu.utm.tn',    '$2y$10$Z0hxkzKXJr3m5XxR1yW4UOqvQf6t9fLQe2bQ0kq8bWm1sYk0xS1yG', '29777888', 'etudiant',  'suspendu');    -- 8

-- Personne 1
INSERT INTO competence (nom, description) VALUES
('Design graphique',  'Logos, affiches, identité visuelle'),          -- 1
('Développement web', 'Sites vitrines, HTML, CSS, PHP'),             -- 2
('Réseaux sociaux',   'Création et animation de pages'),             -- 3
('Traduction',        'Arabe, français, anglais');                   -- 4

INSERT INTO realisation (titre, description, lien, date_realisation, id_competence, id_etudiant) VALUES
('Logo pour un club universitaire',   'Logo et charte couleurs',         'https://behance.net/exemple1', '2026-03-10', 1, 2),
('Affiche de la journée des métiers', 'Affiche A3 imprimée',             NULL,                           '2026-05-02', 1, 2),
('Site vitrine d''un café',           'Site en HTML/CSS/PHP',            'https://github.com/exemple2',  '2026-06-15', 2, 3),
('Page Instagram d''une boutique',    '30 publications en un mois',      NULL,                           '2026-09-01', 3, 8),
('Traduction d''un menu de restaurant','Français vers anglais',          NULL,                           '2026-10-12', 4, 8);

-- Personne 2
INSERT INTO categorie (nom, description) VALUES
('Design',            'Logos, affiches, visuels'),                   -- 1
('Développement web', 'Création et modification de sites'),          -- 2
('Réseaux sociaux',   'Pages Facebook et Instagram'),                -- 3
('Traduction',        'Documents et contenus');                      -- 4

INSERT INTO mission (titre, description, budget, delai_jours, ville, statut, id_categorie, id_client) VALUES
('Créer la page Facebook d''une pâtisserie', 'Création de la page et 10 premières publications', 120.00, 3,  'La Marsa', 'en_cours', 3, 5),  -- 1
('Logo pour une pâtisserie',                 'Logo simple, 3 propositions',                       90.00, 5,  'La Marsa', 'terminee', 1, 5),  -- 2
('Site vitrine pour un cabinet',             'Site de 4 pages avec formulaire de contact',       600.00, 15, 'Tunis',    'ouverte',  2, 6),  -- 3
('Traduire une plaquette',                   'Plaquette de 4 pages, français vers anglais',       80.00, 4,  'Tunis',    'ouverte',  4, 6);  -- 4

-- Personne 3
INSERT INTO entreprise (nom, secteur, ville, site_web, statut, id_recruteur) VALUES
('Agence Digitale Sfax', 'Marketing digital', 'Sfax', 'https://digitalsfax.tn', 'verifiee', 7);   -- 1

INSERT INTO offre_emploi (titre, type_offre, description, ville, salaire, date_publication, date_limite, id_entreprise) VALUES
('Stage en design graphique',     'stage',  'Stage de 2 mois, création de visuels',      'Sfax', 300.00,  '2026-11-01', '2026-12-15', 1),
('Développeur web junior',        'emploi', 'CDI, PHP et MySQL',                          'Sfax', 1400.00, '2026-11-05', '2026-12-31', 1),
('Stage community manager',       'stage',  'Gestion des réseaux sociaux des clients',   'Sfax', NULL,    '2026-11-10', NULL,         1);

-- Personne 4
INSERT INTO candidature (message, prix_propose, statut, id_etudiant, id_mission) VALUES
('Je gère déjà la page d''une boutique, voir mon portfolio.', 120.00, 'acceptee',   8, 1),  -- 1
('Je propose aussi des photos des gâteaux.',                  110.00, 'refusee',    2, 1),  -- 2
('3 propositions de logo en 5 jours.',                         90.00, 'livree',     2, 2),  -- 3
('J''ai déjà fait un site vitrine en PHP.',                   550.00, 'en_attente', 3, 3),  -- 4
('Traduction relue par un enseignant.',                        80.00, 'en_attente', 8, 4);  -- 5

INSERT INTO paiement (montant, mode_paiement, statut, id_candidature) VALUES
(120.00, 'carte',    'bloque', 1),   -- 1 : mission en cours, argent bloqué
( 90.00, 'virement', 'libere', 3);   -- 2 : mission terminée, argent versé à l'étudiante

-- Personne 5
INSERT INTO categorie_formation (nom, description) VALUES
('Design',            'Outils et bases du design graphique'),        -- 1
('Développement web', 'HTML, CSS, JavaScript, PHP'),                 -- 2
('Marketing digital', 'Réseaux sociaux et communication'),           -- 3
('Langues',           'Anglais et français professionnels');         -- 4

INSERT INTO formation (titre, description, niveau, duree_heures, mode, prix, date_debut, id_categorie_formation) VALUES
('Initiation à Canva et Figma',        'Créer ses premiers visuels et maquettes',      'debutant',      12, 'en_ligne',   0.00,  '2026-12-01', 1),
('PHP et MySQL pour débutants',        'Construire un site dynamique pas à pas',       'debutant',      30, 'hybride',    60.00, '2026-12-05', 2),
('JavaScript moderne',                 'DOM, événements et requêtes fetch',            'intermediaire', 24, 'en_ligne',   45.00, '2027-01-10', 2),
('Gérer la page Facebook d''un commerce','Calendrier éditorial et publicités',         'debutant',      8,  'presentiel', 30.00, '2026-12-12', 3),
('Anglais professionnel',              'Emails, entretiens et présentations',          'intermediaire', 20, 'en_ligne',   40.00, '2027-01-15', 4);

-- Commun : réclamations
INSERT INTO reclamation (sujet, description, type_probleme, statut, reponse, date_traitement, id_utilisateur, id_admin) VALUES
('Paiement non reçu',            'La mission « Logo pour une pâtisserie » est terminée mais je ne vois pas le paiement.', 'paiement',    'resolue',    'Le paiement a bien été libéré le 20/11, vérifiez votre compte.', NOW(), 2, 1),
('Mission sans réponse',         'Le client ne répond plus depuis une semaine sur la mission de traduction.',             'mission',     'en_cours',   NULL,                                                         NULL,  8, 1),
('Formation introuvable',        'La formation « JavaScript moderne » n''apparaît plus dans la liste.',                  'formation',   'en_attente', NULL,                                                         NULL,  3, NULL),
('Entreprise pas encore vérifiée','Mon entreprise est en attente de vérification depuis 10 jours.',                       'recrutement', 'en_attente', NULL,                                                         NULL,  7, NULL);

-- =====================================================================
--  REQUÊTES AVEC JOINTURES (une par personne + une commune)
-- =====================================================================

-- Commune : liste des utilisateurs actifs par rôle
SELECT role, COUNT(*) AS nombre
FROM utilisateur
WHERE statut = 'actif'
GROUP BY role;

-- Personne 1 : le portfolio d'un étudiant, avec la compétence de chaque réalisation
SELECT u.prenom, u.nom, c.nom AS competence, r.titre, r.date_realisation
FROM realisation r
JOIN competence  c ON r.id_competence = c.id_competence
JOIN utilisateur u ON r.id_etudiant   = u.id_utilisateur
ORDER BY u.nom, r.date_realisation DESC;

-- Personne 2 : les missions ouvertes, avec leur catégorie et le client
SELECT m.titre, cat.nom AS categorie, m.budget, m.ville, u.prenom AS client
FROM mission m
JOIN categorie   cat ON m.id_categorie = cat.id_categorie
JOIN utilisateur u   ON m.id_client    = u.id_utilisateur
WHERE m.statut = 'ouverte';

-- Personne 3 : les offres de stage et d'emploi, avec l'entreprise
SELECT o.titre, o.type_offre, e.nom AS entreprise, o.ville, o.salaire, o.date_limite
FROM offre_emploi o
JOIN entreprise e ON o.id_entreprise = e.id_entreprise
ORDER BY o.date_publication DESC;

-- Personne 4 : les paiements, avec la candidature, l'étudiant et la mission
SELECT p.id_paiement, p.montant, p.statut AS etat_paiement,
       u.prenom AS etudiant, m.titre AS mission
FROM paiement p
JOIN candidature ca ON p.id_candidature = ca.id_candidature
JOIN utilisateur u  ON ca.id_etudiant   = u.id_utilisateur
JOIN mission     m  ON ca.id_mission    = m.id_mission;

-- Personne 5 : les formations, avec leur catégorie
SELECT f.titre, cf.nom AS categorie, f.niveau, f.duree_heures, f.mode, f.prix, f.date_debut
FROM formation f
JOIN categorie_formation cf ON f.id_categorie_formation = cf.id_categorie_formation
ORDER BY f.date_debut;

-- Commun : Jointure du module : les réclamations avec leur auteur et l'admin qui les traite
SELECT r.sujet, r.type_probleme, r.statut,
       CONCAT(u.prenom, ' ', u.nom) AS auteur,
       CONCAT(a.prenom, ' ', a.nom) AS traitee_par
FROM reclamation r
JOIN      utilisateur u ON r.id_utilisateur = u.id_utilisateur
LEFT JOIN utilisateur a ON r.id_admin       = a.id_utilisateur
ORDER BY r.date_reclamation DESC;
