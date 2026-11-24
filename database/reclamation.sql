-- =====================================================================
--  MAHARA : mise à jour de la base existante (sans tout réimporter)
--  1. Ajout de la table reclamation (commune à tous les modules)
--  2. Vrai mot de passe pour le compte admin de test
--  À exécuter dans phpMyAdmin : base « mahara » > onglet SQL (ou Importer)
-- =====================================================================

USE mahara;

-- ---------------------------------------------------------------------
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

INSERT INTO reclamation (sujet, description, type_probleme, statut, reponse, date_traitement, id_utilisateur, id_admin) VALUES
('Paiement non reçu',            'La mission « Logo pour une pâtisserie » est terminée mais je ne vois pas le paiement.', 'paiement',    'resolue',    'Le paiement a bien été libéré le 20/11, vérifiez votre compte.', NOW(), 2, 1),
('Mission sans réponse',         'Le client ne répond plus depuis une semaine sur la mission de traduction.',             'mission',     'en_cours',   NULL,                                                         NULL,  8, 1),
('Formation introuvable',        'La formation « JavaScript moderne » n''apparaît plus dans la liste.',                  'formation',   'en_attente', NULL,                                                         NULL,  3, NULL),
('Entreprise pas encore vérifiée','Mon entreprise est en attente de vérification depuis 10 jours.',                       'recrutement', 'en_attente', NULL,                                                         NULL,  7, NULL);

-- Compte admin de test : admin@mahara.tn / Admin@2026
UPDATE utilisateur
SET mot_de_passe = '$2y$10$v4jNxKh0jFggT/v8ak.kKeGbqGig.ssz6EG2AkDcVbQDcI1bmuFC2'
WHERE email = 'admin@mahara.tn';

-- Jointure du module : les réclamations avec leur auteur et l'admin qui les traite
SELECT r.sujet, r.type_probleme, r.statut,
       CONCAT(u.prenom, ' ', u.nom) AS auteur,
       CONCAT(a.prenom, ' ', a.nom) AS traitee_par
FROM reclamation r
JOIN      utilisateur u ON r.id_utilisateur = u.id_utilisateur
LEFT JOIN utilisateur a ON r.id_admin       = a.id_utilisateur
ORDER BY r.date_reclamation DESC;
