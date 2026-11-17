<?php
$pageTitle   = 'Mahara | Inscription';
$currentPage = 'inscription';
$old = $old ?? ['role' => 'etudiant', 'nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];
$roleLabels = ['etudiant' => 'compte étudiant', 'client' => 'compte client', 'recruteur' => 'compte recruteur'];
$e = fn(string $k): string => htmlspecialchars($old[$k] ?? '');
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

    <!-- Register Start -->
    <section class="section section-alt">
        <div class="container" style="max-width:1040px">
            <div style="text-align:center;margin-bottom:28px">
                <h1 style="font-size:clamp(32px,4vw,46px)">Crée ton compte</h1>
                <p class="text-muted" style="font-size:18px;margin-top:8px">Commence par choisir ton type de compte.</p>
            </div>
            <form action="index.php?page=inscription" method="post">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect ?? 'accueil') ?>">
                <fieldset class="role-choice" style="border:0;padding:0;margin:0 0 24px">
                    <legend style="position:absolute;left:-9999px">Type de compte</legend>
                    <label class="role-option<?= $old['role'] === 'etudiant' ? ' selected' : '' ?>" data-label="compte étudiant">
                        <span class="top"><svg class="icon" width="34" height="34" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c3 3 9 3 12 0v-5"/><path d="M22 9v6"/></svg><input type="radio" name="role" value="etudiant"<?= $old['role'] === 'etudiant' ? ' checked' : '' ?>></span>
                        <strong>Étudiant freelance</strong>
                        <span>Je propose mes compétences et je réalise des missions.</span>
                    </label>
                    <label class="role-option<?= $old['role'] === 'client' ? ' selected' : '' ?>" data-label="compte client">
                        <span class="top"><svg class="icon" width="34" height="34" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9l1-5h14l1 5"/><path d="M4 9v11h16V9"/><path d="M4 9h16"/><path d="M10 20v-6h4v6"/></svg><input type="radio" name="role" value="client"<?= $old['role'] === 'client' ? ' checked' : '' ?>></span>
                        <strong>Client</strong>
                        <span>J'ai un besoin ou un problème à faire résoudre par un étudiant.</span>
                    </label>
                    <label class="role-option<?= $old['role'] === 'recruteur' ? ' selected' : '' ?>" data-label="compte recruteur">
                        <span class="top"><svg class="icon" width="34" height="34" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6"/><path d="M15 15l6 6"/></svg><input type="radio" name="role" value="recruteur"<?= $old['role'] === 'recruteur' ? ' checked' : '' ?>></span>
                        <strong>Recruteur</strong>
                        <span>Je cherche des talents à embaucher en stage ou en emploi.</span>
                    </label>
                </fieldset>
                <div class="card">
                    <h3 style="font-family:var(--font-body);font-size:20px;margin-bottom:18px">Tes informations · <span id="form-role-label"><?= $roleLabels[$old['role']] ?? 'compte étudiant' ?></span></h3>
<?php if (!empty($erreur)): ?>
                <p role="alert" style="background:#fdecec;color:#a61b1b;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-weight:600"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group"><label for="nom">Nom</label><input id="nom" name="nom" value="<?= $e('nom') ?>" type="text" class="form-control" required></div>
                        <div class="form-group"><label for="prenom">Prénom</label><input id="prenom" name="prenom" value="<?= $e('prenom') ?>" type="text" class="form-control" required></div>
                        <div class="form-group"><label for="email">Email</label><input id="email" name="email" value="<?= $e('email') ?>" type="email" class="form-control" placeholder="prenom.nom@universite.tn" required></div>
                        <div class="form-group"><label for="tel">Téléphone</label><input id="tel" name="telephone" value="<?= $e('telephone') ?>" type="tel" class="form-control"></div>
                        <div class="form-group"><label for="mdp">Mot de passe</label><input id="mdp" name="mot_de_passe" type="password" class="form-control" required></div>
                        <div class="form-group"><label for="mdp2">Confirmer le mot de passe</label><input id="mdp2" name="confirmation" type="password" class="form-control" required></div>
                    </div>
                    <p class="form-help" style="margin-top:14px">Le client indique à la place le nom de son commerce ou de son activité, et le recruteur le nom de son entreprise.</p>
                    <div class="form-actions"><button type="submit" class="btn btn-primary">Créer mon compte</button></div>
                    <p class="text-muted" style="margin-top:16px">Déjà un compte ? <a href="index.php?page=connexion&amp;redirect=<?= urlencode($redirect ?? 'accueil') ?>" style="font-weight:800">Connexion</a></p>
                </div>
            </form>
        </div>
    </section>
    <!-- Register End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
