<?php
require '../php/Tools/Bootstrap.php';

use Classes\Database;
use Classes\Logement;

$logement = new Logement();
$headerTitle = 'Accueil';
$currentPageHeader = CurrentPage::HOME;
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require('../php/Composants/head.php');
    ?>
  <title>ALHaIZ Breizh</title>
  <link rel="stylesheet" href="/ressources/css/index.css" />
  <script src="./ressources/js/index.js"></script>
</head>

<body>
<?php
require('../php/Composants/loader.php');
require('../php/Composants/notch.php');
require('../php/Composants/header.php');
include('../php/Composants/toast.php');
?>
<main>

  <div class="message-bienvenue">
    <h1>Degemer mat !</h1>
    <h1>Trouvez votre location de vacances</h1>
  </div>

  <div class="header-barre-recherche-desktop" id="home-page-search">
    <a href="recherche.php" class="header-lien-boutons" id="index-liens-boutons">
      <img src="./ressources/assets/bed-icon.svg" alt="Icone de lit"><span>Où allez-vous</span>
    </a>
    <a href="recherche.php" class="header-lien-boutons" id="index-liens-boutons">
      <img src="./ressources/assets/calendar-icon.svg" alt="Icone de calendrier"><span>Arrivée - Départ</span>
    </a>
    <a href="recherche.php" class="header-lien-boutons" id="index-liens-boutons">
      <img src="./ressources/assets/travellers-icon.svg" alt="Icone de voyageurs"><span>Voyageurs</span>
    </a>
    <a href="recherche.php" class="header-lien-boutons" id="index-liens-boutons">
      Rechercher
    </a>
  </div>
  <div class="image-barre-recherche-desktop"> <!--barre de cherche-->
    <img src="./ressources/assets/village-7258991.jpg"
         alt="Image de fond, montrant un payasage de la côte Bretonne">
    <div class="logo-container">
      <img alt="Logo" src="ressources/assets/logoFull.svg">
    </div>
  </div>
  <div class="contenu-accueil">
    <div class="degemer-mat">
      <h1>Degemer mat !</h1>
      <h2>Trouvez votre location de vacances</h2>
    </div>

    <h2 class="titre_logement">Les Meilleurs Logements</h2>
    <div class="nav-button">
      <img src="./ressources/assets/arrow-icon.png" alt="Icon" class="nav-left"
           onclick='scrollToLeft(".meilleurs-logements")'>
      <img src="./ressources/assets/arrow-icon.png" alt="Icon" class="nav-right" id="scroll-right"
           onclick='scrollToRight(".meilleurs-logements")'>
    </div>
    <div class="meilleurs-logements">
        <?php
        $res1 = new Logement();
        $cartes1 = $res1->createMeilleursCard();
        if ($cartes1 !== false) {
            $count = 0;
            foreach ($cartes1 as $index => $val) {
                if ($count >= 15) {
                    break;
                }
                if($val['url'] == false){
                  $url_image = "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
                }else{
                  $url_image = $val['url'];
                }
                $prix_arrondis = round($val['price_ttc'] /100);

                ?>
              <div class="card">
                <a href="./logement.php?id=<?php echo htmlentities($val['uuid']); ?>">
                  <div class="card-image">
                    <img src="<?php echo htmlentities($url_image); ?>" alt="Image d'exemple d'un logement" />
                  </div>
                  <div class="card-body">
                    <div class="card-title">
                      <h3><?php echo htmlentities($val['title']); ?></h3>
                    </div>
                    <div class="card-excerpt">
                      <p><?php echo htmlentities($val['city']); ?>, <?php echo htmlentities($val['department']); ?>, France</p>
                    </div>
                    <div class="last-line">
                      <div class="card-avis">
                        <p><strong><?php echo htmlentities($prix_arrondis); ?>€</strong> /nuit</p>
                      </div>
                      <div class="card-avis-icon">
                        <img src="./ressources/assets/user.svg" alt="Star Icon" />
                        <p><?php echo htmlentities($val['capacity']) ?></p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
                <?php
                $count++;
            }
        }else{
          echo "Erreur, aucune annonce de logement chargée";
        }
        ?>
    </div>

    <h2 class="titre_logement">Les Plus Prisés</h2>
    <div class="nav-button">
      <img src="./ressources/assets/arrow-icon.png" alt="Icon" class="nav-left"
           onclick='scrollToLeft(".logement-prise")'>
      <img src="./ressources/assets/arrow-icon.png" alt="Icon" class="nav-right" id="scroll-right"
           onclick='scrollToRight(".logement-prise")'>
    </div>
    <div class="logement-prise">
        <?php
        $res2 = new Logement();
        $cartes_prise = $res2->createPriseCard();
        $count = 0;
        if ($cartes1 !== false) {
          $count = 0;
          foreach ($cartes_prise as $index => $val) {
              if ($count >= 15) {
                  break;
              }
              if($val['url'] == false){
                $url_image = "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png";
              }else{
                $url_image = $val['url'];
              }
              $prix_arrondis = round($val['price_ttc'] /100);

              ?>
            <div class="card">
              <a href="./logement.php?id=<?php echo htmlentities($val['uuid']); ?>">
                <div class="card-image">
                  <img src="<?php echo htmlentities($url_image); ?>" alt="Image d'exemple d'un logement" />
                </div>
                <div class="card-body">
                  <div class="card-title">
                    <h3><?php echo htmlentities($val['title']); ?></h3>
                  </div>
                  <div class="card-excerpt">
                    <p><?php echo htmlentities($val['city']); ?>, <?php echo htmlentities($val['department']); ?>, France</p>
                  </div>
                  <div class="last-line">
                    <div class="card-avis">
                      <p><strong><?php echo htmlentities($prix_arrondis); ?>€</strong> /nuit</p>
                    </div>
                    <div class="card-avis-icon">
                        <img src="./ressources/assets/user.svg" alt="Star Icon" />
                        <p><?php echo htmlentities($val['capacity']) ?></p>
                      </div>
                  </div>
                </div>
              </a>
            </div>
              <?php
              $count++;
          }
      }else{
        echo "Erreur, aucune annonce de logement chargée";
      }
      ?>
  </div>
  </div>
</main>
<?php
$currentPageFooter = CurrentPage::HOME;
require('../php/Composants/footer.php');
?>
<script src="/ressources/js/main.js"></script>
</body>

</html>