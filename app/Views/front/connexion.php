<?php
/**
 * Vue : connexion (front office).
 * Reçoit : $errors (string[]), $email, $redirect, $registered (bool), $csrfToken
 */
$pageTitle   = 'Mahara | Connexion';
$currentPage = 'connexion';
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

    <!-- Auth Start -->
    <section class="auth-wrap">
        <div class="container">
            <form id="form-connexion" class="card auth-card" style="margin:0 auto" action="index.php?page=connexion" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
                <h2 style="margin-bottom:6px">Connexion</h2>
                <p class="text-muted" style="margin-bottom:22px">Content de te revoir sur Mahara.</p>

<?php if ($registered): ?>
                <p role="status" style="background:#e7f6ec;color:#1e7a43;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-weight:600">Compte créé avec succès : tu peux maintenant te connecter.</p>
<?php endif; ?>
<?php if (!empty($errors)): ?>
                <div role="alert" style="background:#fdecec;color:#a61b1b;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-weight:600">
<?php foreach ($errors as $error): ?>
                    <div><?= e($error) ?></div>
<?php endforeach; ?>
                </div>
<?php endif; ?>
                <div class="form-group" style="margin-bottom:16px">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" autocomplete="email" placeholder="prenom.nom@universite.tn" value="<?= e($email) ?>">
                    <small data-erreur="email" style="color:#a61b1b;font-weight:600"></small>
                </div>
                <div class="form-group" style="margin-bottom:22px">
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp" name="mot_de_passe" type="password" class="form-control" autocomplete="current-password">
                    <small data-erreur="mot_de_passe" style="color:#a61b1b;font-weight:600"></small>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                <p class="text-muted" style="margin-top:18px;text-align:center">Pas encore de compte ? <a href="index.php?page=inscription" style="font-weight:800">Inscris-toi</a></p>
            </form>
        </div>
    </section>
    <!-- Auth End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
