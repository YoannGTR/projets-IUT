<?php
require '../php/Tools/Bootstrap.php';

use Classes\Bridge;
use Classes\ICal;
use Classes\Toast;

$user = $auth->getUserDataBackOffice();

Toast::triggerStoredToast();

if(!$user) {
    $auth->redirectToLoginOnLoad(true, true);
}
$fullName = $user['firstname'] . ' ' . $user['lastname'];
$address = $user['address1'];
$phone = $user['phone_number'];
$iban = $user['iban'];
$owner = $user['bank_account_holder'];
$email = $user['email'];
$pseudo = $user['username'];
$firstName = $user['firstname'];
$lastName = $user['lastname'];
$title = $user['title'];
$birthDate = $user['birthdate'];
$avatar = $user['avatar'];

$bridge = new Bridge();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $res = $bridge->deleteSubscriber($_POST['delete']);
    if(!$res) {
      Toast::trigger('Erreur lors de la suppression de l\'abonnement', 'error');
    } else {
      Toast::storeToastForNextPage('Abonnement supprimé avec succès', 'success');
    }
    header('Location: /profile.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_synk'])) {
    $res = $bridge->deleteSynkronizator($_POST['delete_synk']);
    if(!$res) {
        Toast::trigger('Erreur lors de la suppression de l\'abonnement', 'error');
    } else {
        Toast::storeToastForNextPage('Abonnement supprimé avec succès', 'success');
    }
    header('Location: /profile.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scopes'])) {
  if (isset($_POST['scopes']) && is_array($_POST['scopes'])) {
      $selectedScopes = $_POST['scopes'];
      try {
          $res = $bridge->addSynk($selectedScopes, $user['uuid']);
          if(!$res) {
              Toast::trigger('Erreur lors de l\'ajout de l\'abonnement', 'error');
          } else {
              Toast::storeToastForNextPage('Abonnement ajouté avec succès', 'success');
          }
      } catch (\Random\RandomException $e) {
          Toast::trigger($e->getMessage(), 'error');
      }
      header('Location: /profile.php');
      exit();
  }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addSubscriber'])) {
    if (isset($_POST['selected']) && is_array($_POST['selected'])) {
        $selectedUUIDs = $_POST['selected'];
        try {
            $res = $bridge->addSubscriber($selectedUUIDs, $_POST['debut'], $_POST['fin']);
            if(!$res) {
                Toast::trigger('Erreur lors de l\'ajout de l\'abonnement', 'error');
            } else {
                Toast::storeToastForNextPage('Abonnement ajouté avec succès', 'success');
            }
        } catch (\Random\RandomException $e) {
            Toast::trigger($e->getMessage(), 'error');
        }
        header('Location: /profile.php');
        exit();
    }
}


$subscriber = $bridge->getSubscriber($user['uuid']);
$synk = $bridge->getSynkronizator($user['uuid']);
require('../php/Composants/headerBO.php');

$proprio = new ICal();
$logements = $proprio->getAllLogementByProprioId($user['uuid']);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require('../php/Composants/head.php');
    ?>
    <title>ALHaIZ Breizh</title>
    <link rel="stylesheet" href="/ressources/css/profile.css" />
    <link rel="stylesheet" href="/ressources/css/styles.css" />
    <script src="./ressources/js/header.js"></script>
    <script src="./ressources/js/profile.js"></script>
    <script src="./ressources/js/multiselect-dropdown.js"></script>
</head>

<body style="display: flex; flex-direction: column; width: 100%; height: 100%">
<?php
require('../php/Composants/loader.php');
include('../php/Composants/toast.php');
?>

<div id="popup-container-section">
  <div class="sectionText" id="popup">
    <div id="close">X</div>
    <form class="input-row" name="addSubscriber" id="logementForm" method="POST" style="flex-direction: column; margin-top: 0">
      <h2 style="margin-top:0;">Dates</h2>
      <div class="date-container">
        <div class="input-container">
          <p class="profile-label">Date du début</p>
          <label for="debut" class="visually-hidden">Date du début</label>
          <input type="text"
                 id="debut"
                 class="input-field"
                 name="debut"
                 aria-invalid=""
                 placeholder="JJ/MM/AAAA"
                 required
                 inputmode="numeric"
                 pattern="(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/((19|20)\d\d)"
          >
        </div>
        <div class="input-container">
          <p class="profile-label">Date de fin</p>
          <label for="fin" class="visually-hidden">Date de fin</label>
          <input type="text"
                 id="fin"
                 class="input-field"
                 name="fin"
                 aria-invalid=""
                 placeholder="JJ/MM/AAAA"
                 required
                 inputmode="numeric"
                 pattern="(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/((19|20)\d\d)"
          >
        </div>
      </div>
      <a id="error-date">La date de début dois être avant la date de fin.</a>
      <h2 style="margin-top:2rem;">Ajouter des logements</h2>
      <table id="table" class="table table-hover table-mc-light-blue">
        <thead>
        <tr>
          <th>Titre</th>
          <th>Addresse</th>
          <th>Code postal</th>
          <th>
            <input
              type="checkbox"
              id="selectAll"
              name="selectAll"
              value="selectAll" />
            <label for="selectAll">Tout selectionner</label>
          </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($logements as $item) {
            $dataLogement = $proprio->getLogementById($item['logement_uuid'])[0];
            ?>
          <tr>
            <td data-title="Titre"><?php echo $dataLogement["title"]?></td>
            <td data-title="Addresse"><?php echo $dataLogement["street_number"] . " " . $dataLogement['street_name'] . " " . $dataLogement['city']?></td>
            <td data-title="Code postal">
                <?php echo $dataLogement["zipcode"]?>
            </td>
            <td data-title="Select">
              <input
                type="checkbox"
                name="selected[]"
                id="<?php echo $dataLogement['uuid']?>"
                value="<?php echo $dataLogement['uuid']?>" />
              <label for="<?php echo $dataLogement['uuid']?>">Selectionner</label>
            </td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      <a id="error-select">Séléctionner au moins un logement.</a>
      <div class="button-container-add">
        <button type="submit" class="add" name="addSubscriber" id="addData">Ajouter</button>
      </div>
    </form>
  </div>
</div>

<div id="popup-hide-bc"></div>

<main style="height: 100%; width: auto; margin-left:60px">
  <div class="main-container">
    <h1 class="title-profil">Mon profil</h1>
    <section class="profile-container">
      <div class="profile-card">
        <header class="profile-header">
          <div class="profile-info">
            <div class="profile-image-container">
              <img loading="lazy" src="<?php echo $avatar ?>" class="profile-image" alt="Profile picture" />
            </div>
            <div class="profile-details">
              <a class="profile-name"><?php echo $fullName?></a>
              <p class="profile-email"><?php echo $email?></p>
            </div>
          </div>
        </header>
        <h2>Mon compte</h2>
        <form class="input-row">
          <div class="input-container">
            <p class="profile-label">Email</p>
            <label for="email" class="visually-hidden">Votre email</label>
            <input type="text" id="email" value="<?php echo $email?>" class="input-field" placeholder="Votre email" disabled/>
          </div>
          <div class="input-container">
            <p class="profile-label">Pseudo</p>
            <label for="pseudo" class="visually-hidden">Votre pseudo</label>
            <input type="text" id="pseudo" value="<?php echo $pseudo?>" class="input-field" placeholder="Votre pseudo" disabled/>
          </div>
        </form>
        <h2>Informations personnels</h2>
        <form class="input-row">
          <div class="input-container">
            <p class="profile-label">Nom</p>
            <label for="firstName" class="visually-hidden">Votre nom</label>
            <input type="text" id="firstName" value="<?php echo $firstName?>" class="input-field" placeholder="Votre nom" disabled/>
          </div>
          <div class="input-container">
            <p class="profile-label">Prénom</p>
            <label for="lastName" class="visually-hidden">Votre prénom</label>
            <input type="text" id="lastName" value="<?php echo $lastName?>" class="input-field" placeholder="Votre prénom" disabled/>
          </div>
        </form>
        <form class="input-row">
          <div class="input-container">
            <p class="profile-label">Civilité</p>
            <label for="owner" class="visually-hidden">Civilité</label>
            <input type="text" id="owner" class="input-field" value="<?php echo $title?>" placeholder="Votre civilité" disabled/>
          </div>
          <div class="input-container">
            <p class="profile-label">Date de naissance</p>
            <label for="iban" class="visually-hidden">Votre date de naissance</label>
            <input type="text" id="iban" class="input-field" value="<?php echo $birthDate?>" placeholder="Votre date de naissance" disabled/>
          </div>
        </form>
        <form class="input-row">
          <div class="input-container">
            <p class="profile-label">Addresse</p>
            <label for="address" class="visually-hidden">Votre addresse</label>
            <input type="text" id="address" value="<?php echo $address?>" class="input-field" placeholder="Votre addresse" disabled/>
          </div>
          <div class="input-container">
            <p class="profile-label">Numéro de téléphone</p>
            <label for="phone" class="visually-hidden">Votre numéro de téléphone</label>
            <input type="text" id="phone" value="<?php echo $phone?>" class="input-field" placeholder="Numéro de téléphone" disabled/>
          </div>
        </form>
        <h2>Informations bancaires</h2>
        <form class="input-row">
          <div class="input-container">
            <p class="profile-label">Titulaire du compte</p>
            <label for="owner" class="visually-hidden">Votre nom</label>
            <input type="text" id="owner" value="<?php echo $owner?>" class="input-field" placeholder="Votre nom" disabled/>
          </div>
          <div class="input-container">
            <p class="profile-label">IBAN</p>
            <label for="iban" class="visually-hidden">Votre IBAN</label>
            <input type="text" id="iban" value="<?php echo $iban?>" class="input-field" placeholder="Votre IBAN" disabled/>
          </div>
        </form>
      </div>
    </section>
  </div>

  <div class="main-container" id="synkronizator">
    <h1 class="title-profil">Synkronizator</h1>
    <section class="sectionText">
      <form name="scopes[]" class="button-container" method="post">
        <select name="scopes[]" id="field2" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
          <option value="LIST_HOUSING" >Lister les logements</option>
          <option value="READ_HOUSING_CALENDAR" >Lire le calendrier des logements</option>
          <option value="UPDATE_HOUSING_CALENDAR">Mettre à jour le calendrier des logements</option>
        </select>
        <button type="submit" class="add" id="addSynk">Ajouter</button>
      </form>
      <table id="table" class="table table-hover table-mc-light-blue">
        <thead>
        <tr>
          <th>Clé d'API</th>
          <th>Permission(s)</th>
          <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($synk as $item) { ?>
          <tr>
            <td data-title="API"><?php echo $item["api_key"]?></td>
            <td data-title="Scopes">
              <select aria-label="Scopes" class="select-field" name="scopes">
                <!-- <option value="" disabled>Tout les logements</option> -->
                  <?php
                  $data = $bridge->getScopesForAPIKey($item["api_key"]);
                  ?>
                <option value="1" disabled selected><?php echo $data["count"] . " permissions attribuées" ?></option>
                  <?php  foreach ($data["data"] as $scopes) { ?>
                    <option value="1" disabled><?php echo $scopes ?></option>
                  <?php } ?>
              </select>
            </td>
            <td data-title="Remove">
              <form method="POST" name="delete_synk">
                <button type="submit" class="delete" name="delete_synk" value="<?php echo $item["api_key"] ?>">
                  <span class="nav-text">X</span>
                </button>
              </form>
            </td>
          </tr>
        <?php }?>
        </tbody>
      </table>
    </section>
  </div>

  <div class="main-container" id="ical">
    <h1 class="title-profil">Abonnement Ical</h1>
    <section class="sectionText">
      <div class="button-container">
        <a class="add" id="add">Ajouter</a>
      </div>
      <table id="table" class="table table-hover table-mc-light-blue">
        <thead>
        <tr>
          <th>Clé d'API</th>
          <th>Début</th>
          <th>Fin</th>
          <th>Logement(s)</th>
          <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subscriber as $item) { ?>

          <tr>
            <td data-title="API"><a id="abcde" href="https://bnbyte.ventsdouest.dev/ical.php?api_key=<?php echo $item["api_key"]?>"><?php echo $item["api_key"]?></a></td>
            <td data-title="Debut"><?php echo $item["start_date"]?></td>
            <td data-title="Fin">
                <?php echo $item["end_date"]?>
            </td>
            <td data-title="Logement">
              <select aria-label="Logement" class="select-field" name="logement">
                <!-- <option value="" disabled>Tout les logements</option> -->
                  <?php
                  $data = $bridge->getLogementForAPIKey($item["api_key"]);
                  $count = count($data);
                  ?>
                <option value="1" disabled selected><?php echo $count . " logements séléctionnées" ?></option>
                <?php  foreach ($data as $logement) { ?>
                <option value="1" disabled><?php echo $logement['title'] ?></option>
                <?php } ?>
              </select>
            </td>
            <td data-title="Remove">
              <form method="POST" name="delete">
                <button type="submit" class="delete" name="delete" value="<?php echo $item["abonnement_id"] ?>">
                  <span class="nav-text">X</span>
                </button>
              </form>
            </td>
          </tr>
        <?php }?>
        </tbody>
      </table>
    </section>
  </div>
</main>
<?php
$currentPageFooter = CurrentPage::BACKOFFICE;
require('../php/Composants/footer.php');
?>
<script src="/ressources/js/main.js"></script>
</body>

</html>