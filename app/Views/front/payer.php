<?php
$pageTitle   = 'Mahara | Paiement';
$currentPage = 'payer';
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
            <ol class="breadcrumb"><li><a href="index.php?page=accueil">Accueil</a></li><li><a href="index.php?page=mes-missions">Mes missions</a></li><li><a href="index.php?page=candidatures-recues">Candidatures reçues</a></li><li>Paiement</li></ol>
            <h1>Payer la mission</h1>
            <p>Ton argent est bloqué en sécurité par Mahara et versé à l'étudiant seulement après la livraison.</p>
        </div>
    </section>
    <!-- Header End -->


    <!-- Form Start -->
    <section class="section">
        <div class="container">
            <div class="detail-grid">
                <form class="card" action="#" method="post">
                    <h3 style="margin-bottom:20px">Mode de paiement</h3>
                    <div class="pay-options">
                        <label class="role-option selected"><span class="top"><strong>Carte bancaire</strong><input type="radio" name="mode_paiement" value="carte" checked></span><span>Paiement immédiat, carte tunisienne ou internationale.</span></label>
                        <label class="role-option"><span class="top"><strong>Virement</strong><input type="radio" name="mode_paiement" value="virement"></span><span>La candidature est confirmée à réception du virement.</span></label>
                        <label class="role-option"><span class="top"><strong>Espèces</strong><input type="radio" name="mode_paiement" value="especes"></span><span>Dépôt dans un point partenaire Mahara.</span></label>
                    </div>
                    <div class="form-grid" style="margin-top:22px">
                        <div class="form-group full"><label for="titulaire">Titulaire de la carte</label><input id="titulaire" type="text" class="form-control" placeholder="Nom sur la carte"></div>
                        <div class="form-group full"><label for="carte">Numéro de carte</label><input id="carte" type="text" inputmode="numeric" class="form-control" placeholder="0000 0000 0000 0000"></div>
                        <div class="form-group"><label for="exp">Expiration</label><input id="exp" type="text" class="form-control" placeholder="MM/AA"></div>
                        <div class="form-group"><label for="cvv">CVV</label><input id="cvv" type="text" inputmode="numeric" class="form-control" placeholder="123"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Payer 100 TND</button>
                        <a href="index.php?page=candidatures-recues" class="btn btn-outline">Annuler</a>
                    </div>
                </form>
                <aside class="card">
                    <h3 style="margin-bottom:14px">Récapitulatif</h3>
                    <div class="info-row"><span>Mission</span><strong>Page Facebook d'une pâtisserie</strong></div>
                    <div class="info-row"><span>Étudiant</span><strong>Mehdi Trabelsi</strong></div>
                    <div class="info-row"><span>Prix proposé</span><strong>100 TND</strong></div>
                    <div class="info-row"><span>Frais Mahara</span><strong>0 TND</strong></div>
                    <div class="info-row total"><span>Total</span><strong>100 TND</strong></div>
                    <p class="form-help" style="margin-top:16px">Le paiement reste bloqué par Mahara jusqu'à la livraison de la mission, puis il est versé à l'étudiant.</p>
                </aside>
            </div>
        </div>
    </section>
    <!-- Form End -->

    <!-- ========== Contenu spécifique de la page : fin ========== -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>
