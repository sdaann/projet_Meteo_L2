<?php
    declare(strict_types=1);
    $title = "Meteo";
    $h1 = "Meteo";
    require "include/header.inc.php";
    require "include/function.inc.php";
?>
<main>
    <h1><?=$h1;?></h1>
    <section>
        <h2>Selectionnez votre region sur la carte</h2>
        <article>
            <h3>La carte de France</h3>
            <map name="regionmap">
                <area shape="poly" coords="461,36,452,113,470,192,558,207,580,225,592,189,626,126,541,52,463,35" alt="Hauts-de-France" title="Hauts-de-France" href="?region=hauts-de-france"/>
                <area shape="poly" coords="451,213,472,266,496,284,534,300,571,273,558,217,467,195" alt="Ile-de-France" title="Ile-de-France" href="?region=Île-de-france"/>
                <area alt="normandie" title="normandie" href="?region=normandie" coords="240,141,259,246,277,259,339,256,376,272,402,283,407,246,450,215,450,117,366,153,371,173,289,177,238,139" shape="poly"/>
                <area shape="poly" coords="188,352,52,290,54,239,179,249,250,248,280,269" alt="Bretagne" title="Bretagne" href="?region=bretagne"/>
                <area shape="poly" coords="188,354,205,413,265,472,303,466,289,417,289,409,350,393,367,351,407,305,376,273,350,275,289,263,271,327,194,357" alt="Pays de la Loire" title="Pays de la Loire" href="?region=pays%20de%20la%20loire"/>
                <area shape="poly" coords="452,224,412,247,406,291,374,355,352,394,426,462,499,467,549,429,552,308" alt="Centre-Val de Loire" title="Centre-Val de Loire" href="?region=centre-val%20de%20loire"/>
                <area alt="Nouvelle-Aquitaine" title="Nouvelle-Aquitaine" href="?region=nouvelle-aquitaine" coords="211,758,253,640,267,551,271,475,309,469,291,410,372,415,429,469,497,469,512,568,467,611,443,604,400,666,325,708,312,809" shape="poly"/>
                <area shape="poly" coords="446,607,400,697,329,713,318,807,546,849,554,782,624,744,660,701,582,633,499,646,455,620" alt="Occitanie" title="Occitanie" href="?region=occitanie"/>
                <area shape="poly" coords="553,295,580,286,602,318,640,323,658,324,673,337,694,359,726,349,748,325,802,355,736,473,687,457,622,482,595,436,556,331,558,296" alt="Bourgogne-Franche-Comté" title="Bourgogne-Franche-Comté" href="?region=bourgogne-franche-comté"/>
                <area shape="poly" coords="628,125,580,234,608,322,650,313,698,353,753,313,821,356,880,216,664,107,628,127" alt="Grand Est" title="Grand Est" href="?region=grand%20est"/>
                <area shape="poly" coords="532,449,519,541,495,628,528,612,568,605,631,666,696,659,764,592,822,570,788,476,728,486,681,466,672,495,607,495,580,452" alt="Auvergne-Rhône-Alpes" title="Auvergne-Rhône-Alpes" href="?region=auvergne-rhône-alpes"/>
                <area shape="poly" coords="788,599,732,664,738,686,671,683,649,755,785,783,869,691,816,666,812,627" alt="Provence-Alpes-Côte d'Azur" title="Provence-Alpes-Côte d'Azur" href="?region=provence-alpes-côte%20d'azur"/>
            </map>
            <figure><img id="mapImage" src="images/carte_region_nom-copie.jpg" alt="Carte region de france avec nom" usemap="#regionmap"/></figure>
        </article>
        <?php if (isset($_GET['region'])): ?>
        <article>
            <h3>Renseignement du ville</h3>
            <?php
                $regions = get_departments();
            ?>

                <p>Région sélectionnée : <?php echo htmlspecialchars($_GET['region']); ?></p>

                <?php foreach ($regions as $region => $departments): ?>
                    <?php if (strtolower($region) == strtolower($_GET['region'])): ?>

                        <form action="#department" method="get">
                            <input type="hidden" name="region" value="<?php echo htmlspecialchars($_GET['region']); ?>"/>

                            <label for="department">Choisissez un département :</label>
                            <select name="department" id="department" onchange="this.form.submit()">
                                <option value="">-- Sélectionner un département --</option>
                                <?php foreach ($departments as $department): ?>
                                    <option value='<?php echo $department['num']; ?>'
                                        <?php echo (isset($_GET['department']) && $_GET['department'] == $department['num']) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $department['name'] . " - " . $department['num']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>

                        <?php if (!empty($_GET['department'])): ?>
                            <form action="prevision.php" method="get">
                                <input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"/>
                                <input type="hidden" name="department" value="<?php echo $_GET['department']; ?>"/>

                                <label for="ville">Choisissez une ville :</label>
                                <select name="ville" id="ville">
                                    <option value="">-- Sélectionner une ville --</option>
                                    <?php
                                    foreach ($departments as $department) {
                                        if ($department['num'] == $_GET['department']) {
                                            foreach ($department['cities'] as $city) {
                                                echo '<option value="' . $city['name'] . '">' .$city['name']."-" .$city['code'] . '</option>'."\n";
                                            }
                                        }
                                    }
                                    ?>
                                </select>

                                <button type="submit">Afficher</button>
                            </form>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
        </article>
        <?php endif; ?>
    </section>
</main>
<?php
    require "include/footer.inc.php";
?>
