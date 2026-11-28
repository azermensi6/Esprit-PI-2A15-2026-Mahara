-- =====================================================================
--  Module P3 · Recrutement — métier avancé « Poste accessible »
--  À exécuter UNE FOIS dans phpMyAdmin (base mahara, onglet SQL)
--  si la base a été importée avant l'ajout de cette colonne.
-- =====================================================================
ALTER TABLE offre_emploi
    ADD COLUMN accessible TINYINT(1) NOT NULL DEFAULT 0 AFTER salaire;

-- Exemple : l'offre « Développeur web junior » devient accessible
UPDATE offre_emploi SET accessible = 1 WHERE titre = 'Développeur web junior';
