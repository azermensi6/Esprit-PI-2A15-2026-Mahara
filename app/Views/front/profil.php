<?php
/**
 * Vue : profil de l'utilisateur connecté (front office).
 * Reçoit : $user (Utilisateur), $old, $errors, $roles, $statuts, $mdpMin, $flash, $csrfToken
 * Validation JavaScript : assets/js/validation.js (formulaire #form-profil).
 */
$pageTitle   = 'Mahara | Mon profil';
$currentPage = 'profil';
$err = fn(string $champ) => '<small data-erreur="' . $champ . '" style="color:#a61b1b;font-weight:600">'
    . (isset($errors[$champ]) ? e($errors[$champ]) : '') . '</small>';
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
            <div class="card profile-card" style="max-width:820px;margin:0 auto 24px">
                <span class="avatar avatar-lg"><?= e(mb_substr($user->getPrenom(), 0, 1) . mb_substr($user->getNom(), 0, 1)) ?></span>
                <div>
                    <h3><?= e($user->getPrenom() . ' ' . $user->getNom()) ?></h3>
                    <span class="badge"><?= e($roles[$user->getRole()] ?? $user->getRole()) ?></span>
                    <span class="badge badge-outline"><?= e($statuts[$user->getStatut()] ?? $user->getStatut()) ?></span>
                    <small class="text-muted" style="display:block;margin-top:6px">Membre depuis le <?= e(dateFr($user->getDateInscription())) ?></small>
                </div>
            </div>

            <?php if (!empty($flash)): ?>
                <p role="status" style="max-width:820px;margin:0 auto 16px;background:#e7f6ec;color:#1e7a43;border-radius:10px;padding:10px 14px;font-weight:600"><?= e($flash['message']) ?></p>
            <?php endif; ?>

            <form id="form-profil" class="card form-card" action="index.php?page=profil" method="post" novalidate data-mdp-min="<?= (int) $mdpMin ?>">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <h3 style="margin-bottom:20px">Informations personnelles</h3>
                <div class="form-grid">
                    <div class="form-group"><label for="nom">Nom</label><input id="nom" name="nom" type="text" class="form-control" maxlength="50" value="<?= e($old['nom']) ?>"><?= $err('nom') ?></div>
                    <div class="form-group"><label for="prenom">Prénom</label><input id="prenom" name="prenom" type="text" class="form-control" maxlength="50" value="<?= e($old['prenom']) ?>"><?= $err('prenom') ?></div>
                    <div class="form-group"><label for="email">Email</label><input id="email" name="email" type="email" class="form-control" maxlength="100" value="<?= e($old['email']) ?>"><?= $err('email') ?></div>
                    <div class="form-group"><label for="tel">Téléphone</label><input id="tel" name="telephone" type="tel" class="form-control" placeholder="Ex. 22 111 222" value="<?= e($old['telephone']) ?>"><?= $err('telephone') ?></div>
                </div>
                <h3 style="margin:28px 0 8px">Changer le mot de passe</h3>
                <p class="form-help" style="margin-bottom:16px">Laisse ces champs vides pour garder ton mot de passe actuel (<?= (int) $mdpMin ?> caractères minimum).</p>
                <div class="form-grid">
                    <div class="form-group full"><label for="mdp-actuel">Mot de passe actuel</label><input id="mdp-actuel" name="mot_de_passe_actuel" type="password" class="form-control" autocomplete="current-password"><?= $err('mot_de_passe_actuel') ?></div>
                    <div class="form-group"><label for="mdp">Nouveau mot de passe</label><input id="mdp" name="mot_de_passe" type="password" class="form-control" autocomplete="new-password"><?= $err('mot_de_passe') ?></div>
                    <div class="form-group"><label for="mdp2">Confirmer</label><input id="mdp2" name="confirmation" type="password" class="form-control" autocomplete="new-password"><?= $err('confirmation') ?></div>
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
