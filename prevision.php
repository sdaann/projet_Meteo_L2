<?php
    declare(strict_types=1);
    $title = "Prévision";
    $h1 = "Prévision de la ville de";
    require "include/header.inc.php";
    require "include/function.inc.php";
?>

<main>
    <?php
        if (isset($_GET['ville'])) {
            $city = $_GET['ville'];
            $weatherData = getWeatherData($city);
            $temperature = $weatherData['current']['temp_c'];
            $feelsLike = $weatherData['current']['feelslike_c'];
            $condition = $weatherData['current']['condition']['text'];
            $icon = $weatherData['current']['condition']['icon'];
            $windSpeed = $weatherData['current']['wind_kph'];
            $windDir = $weatherData['current']['wind_dir'];
            $humidity = $weatherData['current']['humidity'];
            $precipitation = $weatherData['current']['precip_mm'];
            $sevensDays = array_slice($weatherData['forecast']['forecastday'], 0, 7);
            saveCities($city);
            $info = [
                'ville' => $city,
                'date de consultation' => date("d-m-Y H-i-s")
            ];
            setcookie("derniere_ville", json_encode($info), time() + (86400 * 30), "/");
        }
    ?>
    <h1><?=$h1." ".$city?></h1>
    <section>
<!--        --><?php
//        // Debug des données avant la boucle
//        echo '<pre>';
//        print_r($sevensDays);
//        echo '</pre>';
//        ?>
        <h2>Météo à <?php echo $city; ?></h2>
        <article id="weather">
            <div class="weather-header">
                <div class="weather-icon">
                    <img src="<?php echo $icon; ?>" alt="Météo" width="150" height="150"/>
                </div>
                <div class="climat">
                    <div>
                        <p class="city"><?=$city?></p>
                        <p class="weather-condition"><?=$condition;?></p>
                    </div>
                    <p class="temperature" style="margin-left:20px"><?php echo $temperature; ?>°</p>
                </div>
            </div>

            <div class="forecast-container">
                <div class="forecast-grid">
                    <?php foreach ($sevensDays as $day): ?>
                        <div class="forecast-item">
                            <img src="<?= $day['day']['condition']['icon']; ?>" alt="Meteo"/>
                            <p class="forecast-day"><?= jourDeLaSemaineDuDate($day['date'])?></p>
                            <p class="forecast-temp">Max : <?= $day['day']['maxtemp_c']?>° | Min : <?= $day['day']['mintemp_c']?>°</p>
                            <p class="forecast-condition"><?= $day['day']['condition']['text']; ?></p>
                            <div class="forecast-sun">
                                <p>↑ <?= $day['astro']['sunrise']?></p>
                                <p>↓ <?= $day['astro']['sunset']?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
        <article>
            <h3>Previsions des 24 prochains heures</h3>
            <?php
                $table = "<table>";
                $table .= "<caption>Prévisions des 24 prochaines heures</caption>";

                $table .= "<thead><tr><th>Heure</th><th>Température (°C)</th><th>Humidité (%)</th><th>Pression (mb)</th><th>Pluie</th><th>Vitesse du vent (mph)</th><th>Direction du vent</th><th>Icône</th></tr></thead>";
                $table .= "<tbody>";

                foreach ($weatherData['forecast']['forecastday'][0]['hour'] as $hour) {
                    $table .= "<tr>";
                    $table .= "<td>" . date('H:i:s', strtotime($hour['time'])) . "</td>";

                    $table .= "<td>" . $hour['temp_c'] . "°C</td>";

                    $table .= "<td>" . $hour['humidity'] . "%</td>";

                    $table .= "<td>" . $hour['pressure_mb'] . " mb</td>";

                    $table .= "<td>" . ($hour['will_it_rain'] ? "Oui" : "Non") . "</td>";

                    $table .= "<td>" . $hour['wind_mph'] . " mph</td>";

                    $table .= "<td>" . $hour['wind_dir'] . "</td>";

                    $table .= "<td><img src='" . $hour['condition']['icon'] . "' alt='Icône du ciel' /></td>";

                    $table .= "</tr>";
                }

                $table .= "</tbody></table>";

                echo $table;
            ?>
        </article>
    </section>
</main>
<?php
    require "include/footer.inc.php";
?>
