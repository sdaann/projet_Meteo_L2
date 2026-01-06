<?php
    declare(strict_types=1);
    $title = "Statistiques";
    $h1 = "Statistiques";
    require "include/header.inc.php";
    require "include/function.inc.php";
?>
<main>
    <h1>Statistiques des villes les plus consultées</h1>
    <section>
        <h2>Analyse des Données</h2>
        <article id="histogramme">
            <h3>Histogramme des Consultations</h3>
            <p>Ci-dessous, un histogramme représentant les villes les plus consultées sur notre site.</p>
            <figure>
                <img src="generate_histogramme.php" alt="Histogramme des villes les plus consultées"/>
                <figcaption>Histogramme des villes les plus consultées du site</figcaption>
            </figure>
        </article>

        <?php
            if (isset($_COOKIE["derniere_ville"])){
                echo "<article>";
                $info = json_decode($_COOKIE["derniere_ville"], true);
                echo "<h3>Votre Dernière Consultation</h3>";
                echo "<p>La dernière ville que vous avez visitée est : ".$info["ville"]." le ".$info['date de consultation']."</p>";
                echo "<p><a href='prevision.php?ville=" . $info["ville"] . "'>Cliquez ici</a> pour consulter à nouveau la météo de cette ville.</p>";
                echo "</article>";
            }

        ?>
    </section>
</main>

<?php
    require "include/footer.inc.php";
?>