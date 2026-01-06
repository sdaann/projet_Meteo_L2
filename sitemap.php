<?php
    declare(strict_types=1);
    $title = "Plan du site";
    $h1 = "Plan du site";
    require "include/header.inc.php";
    require "include/function.inc.php";
?>
<main>
    <h1><?=$h1;?></h1>
    <section>
        <h2>Votre feuille de site</h2>
        <div class="project-details">
            <p>Bienvenue sur le plan du site. Cette page vous permet de visualiser l'organisation du site et d'accéder rapidement à ses différentes sections.</p>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="meteo.php">Météo</a></li>
                <li><a href="tech.php">Page Technique</a></li>
                <li><a href="statistiques.php">Statistique</a></li>
                <li><a href="sitemap.php">Plan du site</a></li>
            </ul>
        </div>
    </section>
</main>
<?php
    require "include/footer.inc.php";
?>
