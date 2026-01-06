<?php
    declare(strict_types=1);
    require "include/function.inc.php";
    $title = "Page Technique";
    require "include/header.inc.php";
?>
    <main>
        <h1>Les formats d’échanges JSON et XML des API Web</h1>
        <section>
            <h2>Page technique pour la prise en main des formats d'echanges des API WEB</h2>
            <article>
                <h3>L'image du jour (APOD) de la NASA</h3>

                <?php
                    $apodData = apod();

                    if ($apodData === null) {
                        echo "<p>Impossible de récupérer les données de l'API.</p>";
                        exit;
                    }

                    $explanation = $apodData['explanation'];
                    $mediaType = $apodData['media_type'];
                ?>
                <?php if (isset($apodData['url'])) : ?>
                    <?php if ($mediaType == "video"): ?>
                        <iframe width="80%" src="<?= $apodData['url']; ?>" title="Video recuperer de l'api nasa" height="500px">
                        </iframe>
<!--                        <video controls width="50%">-->
<!--                            <source src="--><?php //= $apodData['url']; ?><!--" type="video/mp4"/>-->
<!--                        </video>-->
                    <?php else: ?>
                        <img id="apod-image" src="<?= $apodData['url']; ?>" alt="Image du jour de la NASA" style="max-width: 800px; height: auto; display: block; margin: auto; padding-bottom: 5px"/>
                    <?php endif; ?>
                <?php else: ?>
                    <p><strong>Message :</strong> <?php echo $apodData['message']; ?></p>
                <?php endif; ?>
                <p lang="en"><strong>Explanation :</strong> <?= nl2br($explanation) ?></p>
            </article>
            <article>
                <h3>Géolocalisation via GeoPlugin </h3>
                <?= positiongeographique(); ?>
            </article>
            <article>
                <h3>Géolocalisation via ipinfo.io</h3>
                <?php
                $geoData = geoposition();
                if ($geoData !== null) {
                    echo "<p>Localisation: " . $geoData['location'] . "</p>";
                    echo "<p>Ville: " . $geoData['city'] . "</p>";
                    echo "<p>Pays: " . $geoData['country'] . "</p>";
                    echo "<p>Region: " . $geoData['region'] . "</p>";
                    echo "<p>Code Postal: " . $geoData['postal'] . "</p>";
                } else {
                    echo "<p>Impossible de recuperer les donnees geographiques.</p>";
                }
                ?>
            </article>
            <article>
                <h3>Géolocalisation via WhatIsMyIP</h3>
                <?= getIp(); ?>
            </article>
        </section>
    </main>

<?php
    require "include/footer.inc.php";
?>