    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="index.php?page=accueil" class="navbar-brand">
                        <img src="app/Views/front/assets/img/logo-icone.png" alt="">
                        <span>MAHARA</span>
                    </a>
                    <p style="margin-top:12px">La plateforme freelance des étudiants tunisiens. Ta mahara, ton avenir.</p>
                </div>
                <div>
                    <h4>Liens rapides</h4>
                    <ul>
<?php if (isLoggedIn()): ?>
                        <li><a href="index.php?page=missions">Missions</a></li>
                        <li><a href="index.php?page=offres">Offres d'emploi</a></li>
                        <li><a href="index.php?page=publier-mission">Publier une mission</a></li>
                        <li><a href="index.php?page=profil">Mon profil</a></li>
<?php else: ?>
                        <li><a href="index.php?page=connexion">Connexion</a></li>
                        <li><a href="index.php?page=inscription">Créer un compte</a></li>
<?php endif; ?>
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="#">Ariana, Tunisie</a></li>
                        <li><a href="#">contact@mahara.tn</a></li>
                        <li><a href="#">+216 70 000 000</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Newsletter</h4>
                    <p>Reçois les nouvelles missions chaque semaine.</p>
                    <form class="newsletter" action="#" onsubmit="return false;">
                        <label for="newsletter-email" class="visually-hidden" style="position:absolute;left:-9999px">Email</label>
                        <input id="newsletter-email" type="email" class="form-control" placeholder="Ton email">
                        <button type="submit" class="btn btn-dark btn-sm">OK</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; 2026 Mahara · Projet Technologies Web 2A · Esprit</span>
                <span><a href="#">Conditions d'utilisation</a> · <a href="#">Confidentialité</a></span>
            </div>
        </div>
    </footer>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="back-to-top" aria-label="Retour en haut"><svg class="icon" width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg></a>
