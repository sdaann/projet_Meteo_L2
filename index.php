<?php
    declare(strict_types=1);
    require "include/function.inc.php";
    $title = "Acceuil";
    require "include/header.inc.php";
?>

    <main class="accueil">
        <h1>Hexagone Météo</h1>
        <section class="hero">
            <div class="hero-content">
                <h2>Hexagone Météo</h2>
                <p class="slogan">Des prévisions météo précises pour mieux planifier vos journées</p>
                <a href="#service" class="cta-button">Découvrir nos services</a>
            </div>
            <aside>
                <?php rand_picture(); ?>
            </aside>
        </section>
        <section>
            <h2>Projet L2 MIASHS</h2>
            <p class="slogan">Site web de prévisions météo développée dans le cadre du projet informatique L2 MIASHS</p>
            <div class="project-details">
                <p>Ce projet utilise :</p>
                <ul>
                    <li>HTML5/CSS3 pour l'interface</li>
                    <li>PHP8 pour le traitement des données</li>
                    <li>API météo externes</li>
                    <li>Stockage CSV des statistiques</li>
                </ul>
            </div>
        </section>
        <section class="cartes-services" id="service">
            <h2>Nos services</h2>
            <div class="grille-cartes">
                <article class="carte">
                    <h3>Prévisions immédiates</h3>
                    <p>Météo des prochaines 24 heures avec précision</p>
                </article>

                <article class="carte">
                    <h3>Prévisions 3 jours</h3>
                    <p>Evolution du temps sur trois jours</p>
                </article>

                <article class="carte">
                    <h3>Données historiques</h3>
                    <p>Histogrammes des villes les plus consultées</p>
                </article>
            </div>
        </section>

        <section>
            <h2>À propos du projet</h2>
                <div class="project-text">
                    <p>Ce projet a été réalisé dans le cadre du projet informatique L2 MIASHS.</p>
                    <p>Il vise à fournir des prévisions météorologiques précises et accessibles pour les utilisateurs en France.</p>
                    <p>Le site utilise des technologies web modernes et des API externes pour offrir une expérience utilisateur optimale.</p>
                </div>
        </section>
    </main>

<?php
require "include/footer.inc.php";
?>