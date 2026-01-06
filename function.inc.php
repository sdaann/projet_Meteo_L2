<?php
    declare(strict_types=1);

    /**
     * @author ANN Seyda Dieynaba
     * @version 1.0
     */

    /**
 * Récupère l'image du jour de la NASA (APOD) avec mise en cache et fallback.
 * @return array|null Données de l'APOD ou image de secours
 */
function apod() : array | null
{
    $cacheFile = 'ressources/cache/apod_cache.json';
    $cacheDuration = 86400; // 24 heures

    // 1. Vérification du cache
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
        $data = json_decode(file_get_contents($cacheFile), true);
        return $data;
    }

    $apiKey = "AcpQfPGPgC5TTLvxHfOdi7CKJbffhBwvNr1CUKhd";
    $date = date("Y-m-d");
    $apiUrl = "https://api.nasa.gov/planetary/apod?api_key=$apiKey&date=$date";

    // 2. Configuration du contexte pour éviter le blocage "HTTP request failed"
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: PHP-Meteo-Project/1.0\r\n"
        ]
    ];
    $context = stream_context_create($options);

    // 3. Appel à l'API avec silence (@) pour gérer l'erreur proprement
    $response = @file_get_contents($apiUrl, false, $context);

    // 4. Gestion de l'erreur (Fallback sur une image fixe si l'API échoue)
    if ($response === FALSE) {
        return [
            'url' => 'https://www.nasa.gov/wp-content/uploads/2023/03/stsci-01evsq6j9p4p66p6mvy8jntnyp.png',
            'explanation' => "L'API NASA est momentanément indisponible sur ce serveur, voici une image d'archive.",
            'media_type' => 'image'
        ];
    }

    $apodData = json_decode($response, true);

    // 5. Traitement des données reçues
    if (isset($apodData['explanation']) && isset($apodData['media_type'])) {
        $data = [
            'url' => $apodData['url'] ?? '',
            'explanation' => $apodData['explanation'],
            'media_type' => $apodData['media_type'],
        ];

        // Sauvegarde dans le cache
        file_put_contents($cacheFile, json_encode($data));
        return $data;
    }

    return null;
}

    /**
     * Récupère les informations de géolocalisation de l'utilisateur via IP.
     * @return array|null Données de géolocalisation ou null
     */
    function geoposition() : array | null
    {
        $cacheFile = 'ressources/cache/ipinfo_cache.json';
        $cacheDuration = 86400;

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            return $data;
        }

        //Pour recuperer l'adresse ip de l'internaute
        $apiIp = $_SERVER['REMOTE_ADDR'];
//        $apiIp = "193.54.115.192";
        $apiUrl = "https://ipinfo.io/{$apiIp}/geo";

        $response = file_get_contents($apiUrl);
        if ($response === FALSE) {
            echo "<p>Impossible de recuperer les donnees de l'api</p>";
            exit;
        }

        $geoData = json_decode($response, true);

        if (isset($geoData['loc']) && isset($geoData['city']) && isset($geoData['country']) && isset($geoData['region']) && isset($geoData['postal'])) {
            $locationData = [
                'location' => $geoData['loc'],
                'city' => $geoData['city'],
                'country' => $geoData['country'],
                'region' => $geoData['region'],
                'postal' => $geoData['postal'],
            ];

            file_put_contents($cacheFile, json_encode($locationData));
            return $locationData;
        }

        return null;
    }

    /**
     * Appelle une API tierce pour récupérer l'IP de l'utilisateur + géolocalisation.
     * @return string Données formatées (HTML) sur la géolocalisation
     */
    function getIp() : string
    {
        $cacheFile = 'ressources/cache/whatismyip_cache.json';
        $cacheDuration = 86400;

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            return affichergeo($data);
        }

        $apiIp = $_SERVER['REMOTE_ADDR'];
//        $apiIp = "193.54.115.192";
        $key = "58e21c0d296331705b8cdaaeb46be9f1";
        $apiUrl = "https://api.whatismyip.com/ip-address-lookup.php?key={$key}&input={$apiIp}&output=xml";

        $response = file_get_contents($apiUrl);
        if ($response === FALSE) {
            echo "<p>Impossible de recuperer les donnees de l'api</p>";
            exit;
        }

        $xml = simplexml_load_string($response);
        if ($xml === FALSE) {
            echo "Erreur lors de l'analyse du XML.";
            exit;
        }

        $serverData = $xml->server_data;

        if (!$serverData) {
            echo "Données géographiques non trouvées.";
            exit;
        }

        $geoData = [
            'ip' => (string) $serverData->ip,
            'country' => (string) $serverData->country,
            'region' => (string) $serverData->region,
            'city' => (string) $serverData->city,
            'postalcode' => (string) $serverData->postalcode,
            'latitude' => (string) $serverData->latitude,
            'longitude' => (string) $serverData->longitude,
            'isp' => (string) $serverData->isp,
        ];

        file_put_contents($cacheFile, json_encode($geoData));

        return affichergeo($geoData);
    }

    /**
     * Génère un affichage HTML de données de géolocalisation.
     * @param array $geoData Données géographiques
     * @return string HTML formaté
     */
    function affichergeo(array $geoData): string
    {
        $str = "<p>IP : ".$geoData['ip']." </p>";
        $str .= "<p>PAYS : ".$geoData['country']." </p>";
        $str .= "<p>REGION : ".$geoData['region']." </p>";
        $str .= "<p>VILLE : ".$geoData['city']." </p>";
        $str .= "<p>CODE POSTAL : ".$geoData['postalcode']." </p>";
        $str .= "<p>LATITUDE : ".$geoData['latitude']." </p>";
        $str .= "<p>LONGITUDE : ".$geoData['longitude']." </p>";
        $str .= "<p>ISP : ".$geoData['isp']." </p>";

        return $str;
    }

    /**
     * Récupère des informations de géolocalisation via l'API geoplugin.
     * @return string Données formatées (HTML)
     */
    function positiongeographique() : string
{
    $cacheFile = 'ressources/cache/geoplugin_cache.json';
    $cacheDuration = 86400;

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
        $data = json_decode(file_get_contents($cacheFile), true);
        return afficherPosition($data);
    }

    $apiIp = $_SERVER['REMOTE_ADDR'];
    $apiUrl = "http://www.geoplugin.net/xml.gp?ip={$apiIp}";

    // CONFIGURATION DU CONTEXTE (Pour éviter le 403 Forbidden)
    $options = [
        "http" => [
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
        ]
    ];
    $context = stream_context_create($options);

    // APPEL AVEC LE SYMBOLE @ POUR CACHER L'ERREUR SI ELLE ÉCHOUE
    $response = @file_get_contents($apiUrl, false, $context);

    // SI L'API RÉPOND 403 OU ÉCHOUE, ON RENVOIE DES DONNÉES PAR DÉFAUT
    if ($response === FALSE) {
        $defaultData = [
            'ip' => $apiIp,
            'country_code' => 'FR',
            'country_name' => 'France (Local)',
            'region_code' => '--',
            'region' => 'Non détectée',
            'city' => 'Ville Inconnue',
            'latitude' => '48.8566',
            'longitude' => '2.3522',
        ];
        return afficherPosition($defaultData);
    }

    $xml = simplexml_load_string($response);
    if ($xml === FALSE) {
        return "<p>Erreur d'analyse des données de géolocalisation.</p>";
    }

    $geoData = [
        'ip' => (string) $xml->geoplugin_request,
        'country_code' => (string) $xml->geoplugin_countryCode,
        'country_name' => (string) $xml->geoplugin_countryName,
        'region_code' => (string) $xml->geoplugin_regionCode,
        'region' => (string) $xml->geoplugin_region,
        'city' => (string) $xml->geoplugin_city,
        'latitude' => (string) $xml->geoplugin_latitude,
        'longitude' => (string) $xml->geoplugin_longitude,
    ];

    file_put_contents($cacheFile, json_encode($geoData));
    return afficherPosition($geoData);
}

    /**
     * Affiche les données de position en HTML.
     * @param array $positionData Données de position
     * @return string HTML formaté
     */
    function afficherPosition(array $positionData): string
    {
        $str = "<p>IP : ".$positionData['ip']." </p>";
        $str .= "<p>Code du Pays : ".$positionData['country_code']." </p>";
        $str .= "<p>Pays : ".$positionData['country_name']." </p>";
        $str .= "<p>Code du Region : ".$positionData['region_code']." </p>";
        $str .= "<p>Nom du region : ".$positionData['region']." </p>";
        $str .= "<p>Nom du city : ".$positionData['city']." </p>";
        $str .= "<p>Latitude : ".$positionData['latitude']." </p>";
        $str .= "<p>Longitude : ".$positionData['longitude']." </p>";

        return $str;
    }

    define("DEFAULT_PATH", "ressources/visitor.txt");
    /**
     * Compte le nombre de visites et l'incrémente
     * Stocke le résultat dans un fichier texte
     * @return int Nombre total de visites
     */
    function get_visits() : int
    {
        if (!file_exists(DEFAULT_PATH)) {
            file_put_contents(DEFAULT_PATH, "0");
        }

        $cpt = intval(file_get_contents(DEFAULT_PATH));
        $cpt++;
        file_put_contents(DEFAULT_PATH, "$cpt");

        return $cpt;
    }

    /**
     * Récupère la liste des départements par région
     * @return array Tableau des départements groupés par région
     */
    function get_departments() : array
    {
        $depFile = fopen("ressources/v_departement_2024.csv", "r");
        $regionFile = fopen("ressources/v_region_2024.csv", "r");
        $cityFile = fopen("ressources/cities.csv", "r");

        $regionCodes = [];
        $regions = [];

        fgetcsv($regionFile, 0, ",", "\"", "\\");
        while (($regionData = fgetcsv($regionFile, 0, ",", "\"", "\\")) !== FALSE) {
            $regionCode = $regionData[0];
            $regionName = $regionData[5];

            $regionCodes[$regionCode] = $regionName;
        }

        fclose($regionFile);

        fgetcsv($depFile, 0, ",", "\"", "\\");
        while (($depData = fgetcsv($depFile, 0, ",", "\"", "\\")) !== FALSE) {
            $regionCode = $depData[1];
            $depNumber = $depData[0];
            $depName = $depData[6];

            if (isset($regionCodes[$regionCode])) {
                $regionName = $regionCodes[$regionCode];

                $regions[$regionName][] = ['num' => $depNumber, 'name' => $depName, 'cities' => []];
            }
        }

        fclose($depFile);

        fgetcsv($cityFile, 0, ",", "\"", "\\");
        while (($cityData = fgetcsv($cityFile, 0, ",", "\"", "\\")) !== FALSE) {
            $cityCode = $cityData[3];
            $cityName = $cityData[4];
            $cityDep = $cityData[1];

            foreach ($regions as &$department) {
                foreach ($department as &$dep) {
                    if ($dep['num'] == $cityDep) {
                        $dep['cities'][] = ['name' => $cityName, 'code' => $cityCode];
                    }
                }
            }
        }
        fclose($cityFile);

        foreach ($regions as $regionName => &$regionDepartments) {
            usort($regionDepartments, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
        }

        foreach ($regions as &$regionDepartments) {
            foreach ($regionDepartments as &$dep) {
                usort($dep['cities'], function ($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
            }
        }

        return $regions;
    }

    /**
     * Récupère les données météo d'une ville depuis l'API WeatherAPI avec cache.
     *
     * @param string $city Nom de la ville
     * @return array Données météo (prévisions, température, etc.)
     */
    function getWeatherData($city) : array
    {
        $city = mb_strtolower($city, 'UTF-8');
        $cityEncoded = urlencode($city);

        $cacheFile = "ressources/cache/weather_{$city}.json";
        $cacheDuration = 86400;

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
            return json_decode(file_get_contents($cacheFile), true);
        }

        $apiKey = "94dda12f829f480186c35621252303";
        $apiUrl = "https://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=$cityEncoded&lang=fr&days=3";
        $response = file_get_contents($apiUrl);
        $weatherData = json_decode($response, true);

        file_put_contents($cacheFile, json_encode($weatherData));
        return $weatherData;
    }

    /**
     * Retourne le jour de la semaine en français à partir d'une date.
     *
     * @param string $date Date au format "Y-m-d"
     * @return string Nom du jour en français
     */
    function jourDeLaSemaineDuDate($date) : string {
        $jours = [
            "Monday"    => "Lundi",
            "Tuesday"   => "Mardi",
            "Wednesday" => "Mercredi",
            "Thursday"  => "Jeudi",
            "Friday"    => "Vendredi",
            "Saturday"  => "Samedi",
            "Sunday"    => "Dimanche"
        ];

        $jourAnglais = date("l", strtotime($date));

        return $jours[$jourAnglais];
    }

    define("CITIES_PATH", "ressources/citiesSave.csv");
    /**
     * Sauvegarde le nom d'une ville consultée dans un fichier CSV avec date/heure.
     *
     * @param string $city Nom de la ville
     * @return void
     */
    function saveCities($city) : void
    {
        $date_consultation = date("Y-m-d H:i:s");
        $file = fopen(CITIES_PATH, "a");
        $city = mb_convert_case($city, MB_CASE_TITLE, "UTF-8");
        fputcsv($file, [$city, $date_consultation], ",", "\"", "\\");

        fclose($file);
    }

    /**
     * Génère un histogramme PNG des villes les plus consultées.
     *
     * @return void
     */
    function generateHistogramme() : void
    {
        $villes = [];
        if (($handle = fopen("ressources/citiesSave.csv", 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $villes[] = $data[0];
            }
            fclose($handle);
        }

        $frequencies = array_count_values($villes);

        $labels = array_keys($frequencies);
        $values = array_values($frequencies);

        $barWidth = 50;
        $spacing = 30;
        $margeGauche = 50;
        $margeDroite = 50;

        $nbBarres = count($values);
        $imageWidth = $margeGauche + $nbBarres * ($barWidth + $spacing) + $margeDroite;
        $imageHeight = 400;

        $image = imagecreatetruecolor($imageWidth, $imageHeight);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $backgroundColor);
        $barColor = imagecolorallocate($image, 0, 0, 255);

        $maxValue = max($values);

        for ($i = 0; $i < count($values); $i++) {
            $barHeight = (int)(($values[$i] / $maxValue) * 300);

            $x1 = (int)($i * ($barWidth + $spacing) + 50);
            $x2 = $x1 + $barWidth;
            $y1 = 350 - $barHeight;
            $y2 = 350;

            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);
            $label = ucfirst(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $labels[$i]));
            imagestringup($image, 5, $i * ($barWidth + $spacing) + 30, 360, $label, $textColor);
        }

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
        exit;
    }

    /**
     * Affiche aléatoirement une image présente dans le dossier "ressources/photos/"
     *
     * @return void
     */
    function rand_picture() : void
    {
        $dossier = "ressources/photos/";
        $fichiers = array_diff(scandir($dossier), ['.', '..']);

        if (!empty($fichiers)) {
            $image_choisie = $fichiers[array_rand($fichiers)];

            echo '<figure>';
            echo '<img src="' . $dossier . $image_choisie . '" alt="Image aléatoire" style="max-width:100%; height:100%"/>';
            echo '<figcaption>' . $image_choisie . '</figcaption>';
            echo '</figure>';
        } else {
            echo '<p>Aucune image trouvée dans le dossier.</p>';
        }
    }
?>