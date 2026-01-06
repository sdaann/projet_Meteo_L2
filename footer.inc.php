<?php
    require 'utils.inc.php';
?>
<button id="backToTop" aria-label="Retour en haut">&#8593;</button>

<script>
    const backToTopButton = document.getElementById("backToTop");

    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    };

    backToTopButton.onclick = function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    };
</script>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Liens utiles</h3>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="meteo.php">Meteo</a></li>
                <li><a href="#">Statistique</a></li>
                <li><a href="tech.php">Page technique</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Suivez-nous</h3>
            <div class="footer-icon">
                <ul>
                    <li><a href="#"><img src="<?= $youtube ?>" alt="Logo de youtube"/></a></li>
                    <li><a href="#"><img src="<?= $instagram ?>" alt="Logo d'instagram"/></a></li>
                    <li><a href="#"><img src="<?= $twitter ?>" alt="Logo de twitter"/></a></li>
                    <li><a href="#"><img src="<?= $snapchat ?>" alt="Logo de snapchat"/></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-section">
            <p><?= getnavigateur() ?></p>
            <p><?= date('l jS \of F Y h:i:s A') ?></p>
            <p><a href="sitemap.php">Cliquez pour visiter le sitemap</a></p>
            <p>La page a été visité <?= get_visits();?> fois</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&#169; 2025 - Projet Informatique - Nanterre Université. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>