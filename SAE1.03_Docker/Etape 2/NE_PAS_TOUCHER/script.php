<?php 
for ($loop = 0; $loop < sizeof($argv); $loop++) 
{
    echo "Le paramètre $loop vaut : " . $argv[$loop] . "\n";
}

$textF = [];
$tabF = [];
$commF = [];
$lines = file($argv[1]);
foreach ($lines as $num => $value)//parcours le fichier
{
    $value = rtrim($value);//enleve les espaces apres la ligne
    $parts = explode("=", $value);//dispatche une ligne en partie pour avoir avant le =
    if(strtoupper($parts[0])=== "CODE")//strtoupper convertit tt en maj
    {
        $iso = strtoupper($parts[1]);
        $line = file("./DONNEES/regions.conf");//explore le regions .conf pour chopper le nom de regions, sa pop sa sup et son nb dep
        foreach ($line as $valeur) {
            $valeur = rtrim($valeur);
            $partie = explode(":",$valeur);
            if ($partie[0] == $iso) {
                array_push($textF, "<section>");
                $val = ("\t" . $partie[1]);
                array_push($textF, $val);//met la valeur dans un tableau
                $val =("\t" . $partie[2]);
                array_push($textF, $val);
                $val = ("\t" . $partie[3]);
                array_push($textF, $val);
                $val = ("\t" . $partie[4]);
                array_push($textF, $val);
                array_push($textF, "</section>");
                array_push($textF, "<section>");
            }
        }
    }
    else if(strtoupper($parts[0])=== "TITRE")//met les titres en h1
    {
        array_push($textF,"\t" . "<h1>". $parts[1] . "</h1>");
    }
    else if(strtoupper($parts[0])=== "SOUS_TITRE")//met les sous-tite en h2
    {
        array_push($textF,"\t" . "<h2>". $parts[1] . "</h2>");
    }
    else if(strtoupper($parts[0])=== "DEBUT_TEXTE" || strtoupper($parts[0])=== "DÉBUT_TEXTE")//met les textes en p
    {
        array_push($textF,"\t" . "<article>");
        $i = 1;
        while(strtoupper(rtrim($lines[$num+$i]))!= "FIN_TEXTE")
        {
            array_push($textF,"\t" . "\t" . "<p>");
            $lines[$num+$i] = rtrim($lines[$num+$i]);
            array_push($textF, "\t" . "\t" . "\t" . $lines[$num+$i]);
            array_push($textF,"\t" . "\t" . "</p>");
            $i++;
        }
        array_push($textF,"\t" . "</article>");
    }
    elseif (strtoupper($parts[0])=== "DEBUT_STATS" || strtoupper($parts[0])=== "DÉBUT_STATS") 
    {
        array_push($tabF,"\t" . "<table>");
        array_push($tabF,"\t" . "\t<thead>");
        array_push($tabF,"\t" . "\t\t<tr>");
        array_push($tabF,"\t" . "\t\t\t<th>Produit</th>");
        array_push($tabF,"\t" . "\t\t\t<th>Ventes</th>");
        array_push($tabF,"\t" . "\t\t\t<th>CA trimestre</th>");
        array_push($tabF,"\t" . "\t\t\t<th>Ventes trimestre an dernier</th>");
        array_push($tabF,"\t" . "\t\t\t<th>CA trimestre an dernier</th>");
        array_push($tabF,"\t" . "\t\t\t<th>evolutonCA (%)</th>");
        array_push($tabF,"\t" . "\t\t</tr>");
        array_push($tabF,"\t" . "\t</thead>");
        $i = 1;
        array_push($tabF,"\t\t<tbody>");
        while(strtoupper(rtrim($lines[$num+$i]))!= "FIN_STATS")
        {
            array_push($tabF,"\t\t\t<tr>");
            //array_push($tabF, "<td>". $lines[$num+$i] . "</td>");
            $lines[$num+$i] = rtrim($lines[$num+$i]);
            $col = explode(",", $lines[$num+$i]);
            $col[0] = rtrim($col[0]);
            $col1 = explode(" ", $col[0]);
            array_push($tabF,"\t\t\t\t<td>" . $col1[1] . "</td>");
            array_push($tabF,"\t\t\t\t<td>" . $col[1] . "</td>");
            array_push($tabF,"\t\t\t\t<td>" . $col[2] . "</td>");
            array_push($tabF,"\t\t\t\t<td>" . $col[3] . "</td>");
            array_push($tabF,"\t\t\t\t<td>" . $col[4] . "</td>");
            
            $col6[0] = ($col[2]/$col[4]-1)*100;
            $col6[1] = abs($col[2]-$col[4]);
            if ($col[2]-$col[4] >= 0) {
                array_push($tabF,"\t\t\t\t<td style = 'color = green' >" . $col6[0] . " | " . $col6[1] . "</td>");//en vert pq positif
            }
            else
            {
                array_push($tabF,"\t\t\t\t<td style = 'color = red' >" . $col6[0] . " | " . $col6[1] . "</td>");//en rouge pq negatif
            }
            

            array_push($tabF,"\t\t\t</tr>");
            $i++;
        }
        array_push($tabF,"\t\t</tbody>");
        array_push($tabF,"\t</table>");
        array_push($tabF, "</section>");
    }
    
    elseif (strtoupper($parts[0])=== "FIN_STATS" || strtoupper($parts[0])=== "FIN_STATS") 
    {
        array_push($commF, "<section>");
        array_push($commF,"\t<h1>Nos meilleurs vendeurs du trimestre</h1>");
        $lines[$num+1] = rtrim($lines[$num+1]);
        $top = explode(",", $lines[$num+1]);
        $tip = explode(":", $top[0]);
        $i =0;
        $top[0] = $tip[1];

        //separe les elements
        foreach($top as $i => $taupe)
        {
            $taupe = explode("=", $taupe);
            $taupe[1] = substr($taupe[1], 0, -4);
            $top[$i] = $taupe;
            $i++;
        }

        //algo de tri
        for ($i=0; $i < count($top) ; $i++)
        {
            $max = $top[$i][1];
            $indmax = $i;
            for ($j=$i+1; $j < count($top) ; $j++) 
            {
                if ($top[$j][1]>$max) {
                    $max = $top[$j][1];
                    $indmax = $j;
                }
                
            }
            $tmp = $top[$indmax];
            $top[$indmax] = $top[$i];
            $top[$i] = $tmp;
        }

        //met dans le fichier
        foreach($top as $i => $topp)
        {
            $topp = implode(" - ", $topp);
            $topp = explode("/", $topp);
            $topp[0] = "\t\t<img src = 'images/" . $topp[0] . ".svg' alt='photo d'employé'>";
            $topp[1] = "\t\t<figcaption>" . $topp[1] . "</figcaption>";
            array_push($commF, "\t" . "<figure>");
            array_push($commF, "\t" . $topp[0]);
            array_push($commF, "\t" . $topp[1]);
            array_push($commF, "\t" . "</figure>");
            
        }
        array_push($commF, "</section>");
        

        
    }

}

 /* implode() fusionne les cellule d'un tableau en une chaîne de
      caractères en utilisant un séparateur (ici \n) entre chaque
      morceau. Il ne reste qu'à écrire la chaîne dans un fichier
      avec file_put_contents().*/

file_put_contents('texte.dat', implode("\n", $textF));
file_put_contents('tableau.dat', implode("\n", $tabF));
file_put_contents('comm.dat', implode("\n", $commF));
?>