#!/usr/local/bin/php
<?php
/** Lancer ce script de cette façon (dans un conteneur Docker sae103-php) :
 * ./sample-args.php toto tutu 123
 * donc avec Docker ça doit être quelque chose du genre (A ADAPTER !!! Notamment le "/Docker/votre_volume") :
 * docker run --rm -ti -v /Docker/votre_volume:/work -w /work sae103-php ./sample-args.php toto lulu 1234
 * Ne pas oublier de faire un chmod +x sample-args.php auparavant (besoin 1 seule fois, à la création du script)
 */
for ($loop = 0; $loop < sizeof($argv); $loop++) {
   echo "Le paramètre $loop vaut : " . $argv[$loop] . "\n";
}
