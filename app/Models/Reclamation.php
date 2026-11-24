<?php

namespace App\Models;

/**
 * Modèle (entité) : une réclamation de la table « reclamation » (commune à tous les modules).
 * Les attributs auteur, auteurEmail, auteurRole et admin viennent des jointures avec utilisateur.
 */
class Reclamation
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $sujet = '';
    private string $description = '';
    private string $typeProbleme = 'autre';   // module concerné
    private string $statut = 'en_attente';   // en_attente, en_cours, resolue ou rejetee
    private ?string $reponse = null;   // réponse de l'administrateur
    private string $dateReclamation = '';
    private ?string $dateTraitement = null;
    private int $idUtilisateur = 0;   // clé étrangère : l'auteur
    private ?int $idAdmin = null;   // clé étrangère : l'admin qui traite (NULL = non attribuée)
    private string $auteur = '';   // jointure : prénom + nom de l'auteur
    private string $auteurEmail = '';   // jointure
    private string $auteurRole = '';   // jointure
    private ?string $admin = null;   // jointure : prénom + nom de l'admin

    // ------------------------------------------------------------
    // GETTERS
    // ------------------------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getSujet(): string
    {
        return $this->sujet;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTypeProbleme(): string
    {
        return $this->typeProbleme;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function getDateReclamation(): string
    {
        return $this->dateReclamation;
    }

    public function getDateTraitement(): ?string
    {
        return $this->dateTraitement;
    }

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }

    public function getAuteurEmail(): string
    {
        return $this->auteurEmail;
    }

    public function getAuteurRole(): string
    {
        return $this->auteurRole;
    }

    public function getAdmin(): ?string
    {
        return $this->admin;
    }

    // ------------------------------------------------------------
    // SETTERS
    // ------------------------------------------------------------

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setTypeProbleme(string $typeProbleme): void
    {
        $this->typeProbleme = $typeProbleme;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setReponse(?string $reponse): void
    {
        $this->reponse = $reponse;
    }

    public function setDateReclamation(string $dateReclamation): void
    {
        $this->dateReclamation = $dateReclamation;
    }

    public function setDateTraitement(?string $dateTraitement): void
    {
        $this->dateTraitement = $dateTraitement;
    }

    public function setIdUtilisateur(int $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    public function setIdAdmin(?int $idAdmin): void
    {
        $this->idAdmin = $idAdmin;
    }

    public function setAuteur(string $auteur): void
    {
        $this->auteur = $auteur;
    }

    public function setAuteurEmail(string $auteurEmail): void
    {
        $this->auteurEmail = $auteurEmail;
    }

    public function setAuteurRole(string $auteurRole): void
    {
        $this->auteurRole = $auteurRole;
    }

    public function setAdmin(?string $admin): void
    {
        $this->admin = $admin;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $reclamation = new self();

        $reclamation->setId((int) ($row['id_reclamation'] ?? 0));
        $reclamation->setSujet((string) ($row['sujet'] ?? ''));
        $reclamation->setDescription((string) ($row['description'] ?? ''));
        $reclamation->setTypeProbleme((string) ($row['type_probleme'] ?? 'autre'));
        $reclamation->setStatut((string) ($row['statut'] ?? 'en_attente'));
        $reclamation->setReponse(isset($row['reponse']) ? (string) $row['reponse'] : null);
        $reclamation->setDateReclamation((string) ($row['date_reclamation'] ?? ''));
        $reclamation->setDateTraitement(isset($row['date_traitement']) ? (string) $row['date_traitement'] : null);
        $reclamation->setIdUtilisateur((int) ($row['id_utilisateur'] ?? 0));
        $reclamation->setIdAdmin(isset($row['id_admin']) ? (int) $row['id_admin'] : null);
        $reclamation->setAuteur((string) ($row['auteur'] ?? ''));
        $reclamation->setAuteurEmail((string) ($row['auteur_email'] ?? ''));
        $reclamation->setAuteurRole((string) ($row['auteur_role'] ?? ''));
        $reclamation->setAdmin(isset($row['admin']) ? (string) $row['admin'] : null);

        return $reclamation;
    }
}
