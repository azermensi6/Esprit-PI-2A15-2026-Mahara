<?php
$pageTitle   = 'Mahara | Mon profil';
$currentPage = 'profil';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<?php require_once __DIR__ . '/includes/head.php'; ?>
</head>

<body>
<?php require_once __DIR__ . '/includes/spinner.php'; ?>
<?php require_once __DIR__ . '/includes/navbar.php'; ?>

    <!-- ========== Contenu spécifique de la page : début ========== -->

    <!-- Header Start -->
    <section class="page-header">
        <div class="container">
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li>Mon profil</li></ol>
            <h1>Mon profil</h1>
            <p>Mets à jour tes informations personnelles et ton mot de passe.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
<?php $u = currentUser(); $roles = ['etudiant' => 'Étudiant freelance', 'client' => 'Client', 'recruteur' => 'Recruteur', 'admin' => 'Administrateur']; ?>
            <div class="card profile-card" style="max-width:820px;margin:0 auto 24px">
                <span class="avatar avatar-lg"><?= htmlspecialchars(mb_substr($u['prenom'], 0, 1) . mb_substr($u['nom'], 0, 1)) ?></span>
                <div>
                    <h3><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></h3>
                    <span class="badge"><?= $roles[$u['role']] ?? $u['role'] ?></span>
                </div>
            </div>
            <form class="card form-card" action="#" method="post">
                <h3 style="margin-bottom:20px">Informations personnelles</h3>
                <div class="form-grid">
                    <div class="form-group"><label for="nom">Nom</label><input id="nom" name="nom" type="text" class="form-control" value="<?= htmlspecialchars($u['nom']) ?>" required></div>
                    <div class="form-group"><label for="prenom">Prénom</label><input id="prenom" name="prenom" type="text" class="form-control" value="<?= htmlspecialchars($u['prenom']) ?>" required></div>
                    <div class="form-group"><label for="email">Email</label><input id="email" name="email" type="email" class="form-control" placeholder="prenom.nom@universite.tn"></div>
                    <div class="form-group"><label for="tel">Téléphone</label><input id="tel" name="telephone" type="tel" class="form-control" placeholder="Ex. 22 111 222"></div>
                </div>
                <h3 style="margin:28px 0 20px">Changer le mot de passe</h3>
                <div class="form-grid">
                    <div class="form-group full"><label for="mdp-actuel">Mot de passe actuel</label><input id="mdp-actuel" name="mot_de_passe_actuel" type="password" class="form-control"></div>
                    <div class="form-group"><label for="mdp">Nouveau mot de passe</label><input id="mdp" name="mot_de_passe" type="password" class="form-control"></div>
                    <div class="form-group"><label for="mdp2">Confirmer</label><input id="mdp2" name="confirmation" type="password" class="form-control"></div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="index.php?page=accueil" class="btn btn-outline">Annuler</a>
                </div>
            </form>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
