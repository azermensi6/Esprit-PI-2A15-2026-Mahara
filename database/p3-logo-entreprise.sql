-- Module P3 · Recrutement — métier avancé : logo de l'entreprise
-- À exécuter UNE fois dans phpMyAdmin (base mahara > onglet SQL) si ta base existe déjà.
-- Le fichier image est enregistré dans le dossier uploads/logos ; la base garde seulement son nom.
ALTER TABLE entreprise ADD COLUMN logo VARCHAR(255) NULL AFTER site_web;
