<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Thierno Abasse DIALLO" />
    <meta name="author" content="Seyda Ann" />
    <meta name="description" content="Consultez la météo à 3 jours pour toutes les villes de France : températures, précipitations, prévisions heure par heure et alertes météo en temps réel."/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="styles/style.css" />
    <?php
        $youtube = "images/youtube_sombre.png";
        $instagram = "images/instagram_sombre.png";
        $twitter = "images/twitter_sombre.png";
        $snapchat = "images/logo-snapchat-noir.png";
        $style = "styles/style.css";
        $url = "?style=sombre";
        $img = "images/claire.png";
        $logo = "images/logo-meteo.png";
        if (!empty($_GET['style'])){
            if ($_GET['style'] == "sombre"){
                $style = "styles/style_night.css";
                $url = "?style=claire";
                $img = "images/sombre.png";
                $logo = "images/logo-dark.jpg";
                setcookie("style", "sombre", time() + 86400, "/");
            }else {
                setcookie("style", "claire", time() + 86400, "/");
            }
        }elseif (isset($_COOKIE["style"]) && $_COOKIE["style"] == "sombre"){
            $style = "styles/style_night.css";
            $url = "?style=claire";
            $img = "images/sombre.png";
            $logo = "images/logo-dark.jpg";
        }
    ?>
    <link rel="stylesheet" href="<?= $style; ?>" />
    <link rel="shortcut icon" type="image/png" href="images/logo-meteo.png"/>
    <style>
        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: #2471A3;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            display: none;
        }

        #backToTop:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <figure>
        <a href="index.php">
            <img src="<?= $logo; ?>" alt="Logo du site"/>
        </a>
    </figure>


    <nav>
        <ul>
            <li><a href="meteo.php">Météo d'une ville</a></li>
            <li><a href="statistiques.php">Statistiques</a></li>
        </ul>
    </nav>

    <a href="<?= $url ?>">
        <img src="<?= $img; ?>" alt="icone pour le changement de theme" />
    </a>
</header>
