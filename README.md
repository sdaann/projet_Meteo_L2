# 🌦️ Hexagone Météo - Projet L2 MIASHS

**🌐 Accéder au site en direct :** [https://seydaann.alwaysdata.net/](https://seydaann.alwaysdata.net/)

Ce projet consiste en la conception et la réalisation d'une application web dynamique dédiée à la météorologie nationale française. Il a été développé dans le cadre de l'UE informatique de la Licence 2 MIASHS à l'Université Paris Nanterre.

## 🌟 Fonctionnalités
- **Recherche Géographique** : Navigation intuitive par régions, départements et villes via une carte interactive.
- **Prévisions détaillées** : Affichage des données météo (température, vent, humidité, pluie) sur 24 heures et 7 jours via *WeatherAPI*.
- **Statistiques Dynamiques** : Suivi des consultations par ville avec génération d'un histogramme en PHP (bibliothèque GD).
- **Géolocalisation par IP** : Détection automatique de la position de l'utilisateur pour un affichage contextuel.
- **Expérience Utilisateur** : 
  - Mode sombre (Dark Mode) disponible.
  - Image du jour de la NASA (API APOD).
  - Images aléatoires à l'accueil et détection du navigateur utilisé.
  - Utilisation de cookies pour mémoriser la dernière recherche.

## 🛠️ Instructions pour exécuter le code
Le projet est optimisé pour un environnement **PHP 8.3**.

1. **Déploiement** : Transférer l'intégralité des fichiers sur votre serveur (ex: Alwaysdata) via un client FTP comme FileZilla.
2. **Configuration serveur** :
   - S'assurer que le serveur autorise les flux sortants pour les appels API (cURL ou `allow_url_fopen`).
   - Le code gère les erreurs de dépréciation de PHP 8.3 pour les fonctions `fgetcsv` et `fputcsv`.
3. **Droits d'écriture** : Il est impératif que le répertoire `ressources/` et ses sous-dossiers (`cache/`, `photos/`) possèdent les droits d'écriture (chmod 755 ou 777) pour :
   - La mise à jour du compteur de visites (`visitor.txt`).
   - Le stockage des statistiques dans `citiesSave.csv`.
   - La gestion du cache JSON pour limiter les appels API.

## 📂 Structure du dépôt
- `index.php` : Page d'accueil du site.
- `meteo.php` & `prevision.php` : Logique d'affichage des données météorologiques.
- `statistiques.php` : Visualisation des données de fréquentation.
- `tech.php` : Page technique (NASA, Géolocalisation).
- `include/function.inc.php` : Cœur du projet contenant l'ensemble des fonctions métier et appels API.
- `ressources/` : Dossier contenant les bases de données CSV, les photos et les fichiers de cache.
- `rapport/` : **Contient les sources LaTeX (.tex), les captures d'écran et le rapport final (.pdf).**

## 👥 Membres du groupe
- **ANN Seyda Dieynaba**
- **COULIBALY Hawa**

---
*Projet réalisé à l'Université Paris Nanterre - Année universitaire 2025/2026*
