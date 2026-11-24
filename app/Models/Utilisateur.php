<?php

namespace App\Models;

/**
 * Modèle (entité) : un utilisateur de la table « utilisateur ».
 * Uniquement des attributs privés, des getters/setters et fromArray() : aucune requête SQL ici
 * (le SQL est dans AuthController et UtilisateurController).
 */
class Utilisateur
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $nom = '';
    private string $prenom = '';
    private string $email = '';
    private string $motDePasse = '';   // toujours haché (password_hash)
    private string $telephone = '';
    private string $role = 'etudiant';   // etudiant, client, recruteur ou admin
    private string $statut = 'en_attente';   // en_attente, actif ou suspendu
    private string $dateInscription = '';
    private int $nbReclamations = 0;   // calculé par la jointure avec reclamation

    // ------------------------------------------------------------
    // GETTERS
    // ------------------------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getDateInscription(): string
    {
        return $this->dateInscription;
    }

    public function getNbReclamations(): int
    {
        return $this->nbReclamations;
    }

    // ------------------------------------------------------------
    // SETTERS
    // ------------------------------------------------------------

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setDateInscription(string $dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

    public function setNbReclamations(int $nbReclamations): void
    {
        $this->nbReclamations = $nbReclamations;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $utilisateur = new self();

        $utilisateur->setId((int) ($row['id_utilisateur'] ?? 0));
        $utilisateur->setNom((string) ($row['nom'] ?? ''));
        $utilisateur->setPrenom((string) ($row['prenom'] ?? ''));
        $utilisateur->setEmail((string) ($row['email'] ?? ''));
        $utilisateur->setMotDePasse((string) ($row['mot_de_passe'] ?? ''));
        $utilisateur->setTelephone((string) ($row['telephone'] ?? ''));
        $utilisateur->setRole((string) ($row['role'] ?? 'etudiant'));
        $utilisateur->setStatut((string) ($row['statut'] ?? 'en_attente'));
        $utilisateur->setDateInscription((string) ($row['date_inscription'] ?? ''));
        $utilisateur->setNbReclamations((int) ($row['nb_reclamations'] ?? 0));

        return $utilisateur;
    }
}
