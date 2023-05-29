<?php
    $linesTxt = file($argv[1]);//ouvre texte.dat
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php 
            $linesTxt[1] = trim($linesTxt[1]);
            echo("Région " . $linesTxt[1]);
            ?></title>
        <style>
<?php 
                $linesCSS = file("./NE_PAS_TOUCHER/style.css");
                foreach($linesCSS as $num => $css)
                {
                        echo ("\t\t" . $css);
                }
                echo "\n";
?>
        </style>
    </head>
    <body>
        <main>
            <section class="p_couverture">
                <h1><?php echo (trim($linesTxt[1])); ?></h1>
                <h2><?php echo (trim($linesTxt[2])); ?> millions d'habitant</h2>
                <h2>Superficie : <?php echo (trim($linesTxt[3])); ?> km²</h2>
                <h2>Nombres de départements : <?php echo (trim($linesTxt[4])); ?></h2>
                <img src="../../DONNEES/logos_regions/<?php  

                    $lineConf = file("./DONNEES/regions.conf");//explore le regions .conf pour chopper le code iso
                    foreach ($lineConf as $valeur) {
                        $valeur = rtrim($valeur);
                        $partie = explode(":",$valeur);
                        if ($partie[1] == trim($linesTxt[1]))
                        {
                            $iso = $partie[0];
                        }
                    }
                    echo $iso;

                ?>.png" alt="logo <?php echo (trim($linesTxt[1])); ?>" title="logo <?php echo (trim($linesTxt[1])); ?>">
                <hr>
                <p class="bottom"><?php echo (date("d/m/Y H:i")); ?></p>
            </section>
            <section>
                <br>
                <h1>Résultats trimestriels <?php 
                    $annee=date("Y");
                    $mois=date("m");
                    $mois = 1;
                    $a = 5;
                    while ($mois <= 12) {
                        $mois+=3;
                        $a--;
                    }
                    echo ("0" . $a . "-" . $annee);
                ?></h1>
<?php 
    for ($i=7; $i < count($linesTxt) ; $i++) { 
        echo ("\t" . $linesTxt[$i]);
    }
    echo "\n";
    $linesTab = file($argv[2]);//ouvre tableau.dat
    $linesTab = str_replace("style = 'color =", "style = 'color :", $linesTab);
    $tmp = "\t<p class=\"bottom\">" . date("d/m/Y H:i") . "</p>";
    $linesTab = str_replace("</section>", $tmp . "\n\t\t\t</section>", $linesTab);
    
    foreach($linesTab as $tab)
    {
        echo ("\t\t" . $tab);
    }
?>
              
<?php 
    $linesComm = file($argv[3]);//ouvre comm.dat
    $apo = "'";
    $gui = '"';
    $linesComm = str_replace(".svg' alt='photo d'employé'", '.png\' alt=\'photo d&#39employé\'', $linesComm);
    $linesComm = str_replace("</h1>", "</h1>\n\t\t\t\t<div class='images'>", $linesComm);
    $linesComm = str_replace("src = 'images/", "src='../photosGen/", $linesComm);
    foreach($linesComm as $num => $comm)
    {
        if($num<=13)
        {
            echo ("\t\t\t" . $comm);
        }
    }
    
    echo ("\t\t\t\t</div>\n");
    echo ("<p class=\"bottom\">" . date("d/m/Y H:i") . "</p>");
    echo ("\t\t\t</section>");
?>

            <section>
                <h1>Page internet</h1>
                <a href="https://bigbrain.biz/<?php echo $iso; ?>">https://bigbrain.biz/<?php echo $iso; ?></a>
                <img id="qr" src="../CODES_QR/<?php echo ($iso); ?>.png" alt="qrcode du site bigbrain">
            </section>
        </main>
    </body>
</html>