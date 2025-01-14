document.querySelector('.photo-description').classList.add('js');

document.querySelectorAll('input').forEach((input) => {
  input.disabled = true;
});

function initMap() {
  // Ceci est nécessaire même si nous n'affichons pas la carte
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {
      lat: -33.867,
      lng: 151.195,
    },
    zoom: 15,
  });

  var placeId = placeid; // Remplacez par votre place_id
  var request = {
    placeId: placeId,
    fields: ['formatted_address'],
  };

  var service = new google.maps.places.PlacesService(map);

  service.getDetails(request, function (place, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      // console.log('Formatted Address: ', place.formatted_address);
      document.getElementById('adresse').value = place.formatted_address;
    } else {
      console.log('Place details request failed due to ', status);
    }
  });
}

// function suppr(event) {
//   event.preventDefault();

//   // Votre condition à vérifier
//   const confirmation = confirm('Voulez-vous vraiment supprimer le logement ?');

//   if (confirmation) {
//     // Si la condition n'est pas remplie, redirige vers l'URL cible
//     window.location.href = event.target.href;
//   }
// }


function changeState(event, uuid) {
  console.log(event);
  event.preventDefault();

  state = event.target.id;
  const confirmation = confirm('Voulez-vous vraiment changer l\'état du logement ?');
  if (confirmation) {
    // Créer une nouvelle requête
    var xhr = new XMLHttpRequest();
  
    // Configurer la requête: méthode POST et URL du fichier PHP
    xhr.open("POST", "update-etat-logement.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Définir la fonction de rappel pour traiter la réponse
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Afficher la réponse du serveur
            console.log("success");
            console.log(xhr.responseText);
            if(state == "OFFLINE") {
  
              document.getElementById('OFFLINE').innerText = "En ligne";
              document.getElementById('OFFLINE').id = "ONLINE";
              
            } else {
              document.getElementById('ONLINE').innerText = "Hors ligne";
              document.getElementById('ONLINE').id = "OFFLINE";
            }
            
        }
    };
  
    // Définir les données à envoyer
    var data = "id=" + uuid + "&state=" + state;
  
    // Envoyer la requête avec les données
    xhr.send(data);
  }
}