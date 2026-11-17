<?php
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
            <form class="card auth-card" style="margin:0 auto" action="#" method="post">
                <h2 style="margin-bottom:6px">Connexion</h2>
                <p class="text-muted" style="margin-bottom:22px">Content de te revoir sur Mahara.</p>
                <div class="form-group" style="margin-bottom:16px">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="prenom.nom@universite.tn" required>
                </div>
                <div class="form-group" style="margin-bottom:12px">
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp" name="mot_de_passe" type="password" class="form-control" required>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:22px;flex-wrap:wrap">
                    <label class="check"><input type="checkbox" name="souvenir"> Se souvenir de moi</label>
                    <a href="#" style="font-weight:700">Mot de passe oublié ?</a>
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
