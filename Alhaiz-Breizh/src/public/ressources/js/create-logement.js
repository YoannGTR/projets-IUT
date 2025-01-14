// pour le +

document.querySelector('.photo-description').classList.add('js');

var fileInput = document.querySelector('.input-file'),
  button = document.querySelector('.input-file-trigger');

button.addEventListener('keydown', function (event) {
  if (event.keyCode == 13 || event.keyCode == 32) {
    fileInput.focus();
  }
});
button.addEventListener('click', function (event) {
  fileInput.focus();
  return false;
});
fileInput.addEventListener('mouseover', function (event) {
  button.style.backgroundColor = '#5d7b95';
  document.querySelector('#addPhoto').setAttribute('fill', '#fff');
});
fileInput.addEventListener('mouseout', function (event) {
  button.style.backgroundColor = '#738da9';
  document.querySelector('#addPhoto').setAttribute('fill', '#000');
});
fileInput.addEventListener('change', function (event) {
  previewImage();
  fileInput.addEventListener('mouseover', function (event) {
    button.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    button.style.backgroundBlendMode = 'darken';
    document.querySelector('#addPhoto').setAttribute('fill', '#fff');
  });
  fileInput.addEventListener('mouseout', function (event) {
    button.style.backgroundBlendMode = 'normal';
    document.querySelector('#addPhoto').setAttribute('fill', '#000');
  });
});
function previewImage() {
  const fileInput = document.getElementById('my-file');
  const file = fileInput.files[0];
  const imagePreviewContainer = document.getElementById(
    'previewImageContainer',
  );

  if (file.type.match('image.*')) {
    const reader = new FileReader();

    reader.addEventListener('load', function (event) {
      const imageUrl = event.target.result;
      imagePreviewContainer.style.backgroundImage = `url(${imageUrl})`;
      imagePreviewContainer.style.backgroundSize = 'cover';
      imagePreviewContainer.style.backgroundPosition = 'center';
    });

    reader.readAsDataURL(file);
  }
}

const activites = document.querySelectorAll('.CBActivite');

activites.forEach((activite) => {
  activite.addEventListener('change', () => {
    if (activite.checked) {
      document.querySelector('#perimeter' + activite.id).style.display =
        'block';
        document.querySelector('#perimeter' + activite.id).required = true;
    } else {
      console.log(activite.id);
      document.querySelector('#perimeter' + activite.id).style.display = 'none';
      document.querySelector('#perimeter' + activite.id).required = false;
    }
  });
});

document.querySelectorAll('.inputNumber').forEach((input) => {
  //check the format of the number when you leave the input
  input.addEventListener('blur', function (e) {
    var quantity = parseInt(e.target.value);
    if (Number.isNaN(quantity) || quantity < 0 || quantity % 1 !== 0) {
      e.target.value = '';
    }
    var quantity = parseInt(e.target.value);
  });

  //check the format of the number when you change the input
  input.addEventListener('input', function (e) {
    const regex = /\D/gi;
    e.target.value = e.target.value.replace(regex, '');
    var quantity = parseInt(e.target.value);
    if (quantity < 0) {
      e.target.value = 0;
    }
  });
});

// function initAutocomplete() {
//   const input = document.getElementById('adresse');
//   const options = {
//     types: ['address'],
//     componentRestrictions: { country: 'fr' },
//     strictBounds: true,
//   };

//   const autocomplete = new google.maps.places.Autocomplete(input, options);

//   autocomplete.addListener('place_changed', function () {
//     const place = autocomplete.getPlace();
//     if (!place.geometry) {
//       console.log("No details available for input: '" + place.name + "'");
//       return;
//     }
//     // Vérifier que le type de place est une adresse
//     if (
//       !(
//         place.types.includes('street_address') ||
//         place.types.includes('premise')
//       )
//     ) {
//       console.log('Place is not an address');
//       return;
//     }
//     console.log(place.formatted_address);
//     // Vous pouvez maintenant utiliser les informations de place pour vos besoins.
//   });

//   // Restreindre les résultats à la région de Bretagne
//   const bounds = new google.maps.LatLngBounds(
//     new google.maps.LatLng(47.4, -4.9), // Sud-Ouest de la Bretagne
//     new google.maps.LatLng(48.8, -1.2), // Nord-Est de la Bretagne
//   );
//   autocomplete.setBounds(bounds);
// }

function initAutocomplete() {
  var autocomplete = new google.maps.places.Autocomplete(
    document.getElementById('adresse'),
    {
      types: ['address'],
      componentRestrictions: { country: 'fr' },// Limiter aux adresses en France par exemple
      strictBounds: true 
    },
  );
  // Restreindre les résultats à la région de Bretagne
  const bounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(47.4, -4.9), // Sud-Ouest de la Bretagne
    new google.maps.LatLng(48.8, -1.2), // Nord-Est de la Bretagne
  );
  autocomplete.setBounds(bounds);

  autocomplete.addListener('place_changed', function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("No details available for input: '" + place.name + "'");
      document.getElementById('adresse').value = '';
      return;
    }

    var department = '';
    var region = '';
    var country = '';
    var postalCode = '';
    var ville = '';
    var streetNumber = '';
    var streetName = '';
    var lattitude = place.geometry.location.lat();
    var longitude = place.geometry.location.lng();
    var placeId = place.place_id;

    for (var i = 0; i < place.address_components.length; i++) {
      var component = place.address_components[i];
      if (component.types.includes('administrative_area_level_2')) {
        department = component.long_name;
      }
      if (component.types.includes('administrative_area_level_1')) {
        region = component.long_name;
      }
      if (component.types.includes('country')) {
        country = component.long_name;
      }
      if (component.types.includes('postal_code')) {
        postalCode = component.long_name;
      }
      if (component.types.includes('locality')) {
        ville = component.long_name;
      }
      if (component.types.includes('street_number')) {
        streetNumber = component.long_name;
      }
      if (component.types.includes('route')) {
        streetName = component.long_name;
      }
     

    }

    if (department && region && country && postalCode && ville && streetName && lattitude && longitude && placeId) {
      console.log('Address: ' + place.formatted_address);
      console.log('Department: ' + department);
      console.log('Region: ' + region);
      console.log('Country: ' + country);
      console.log('Postal Code: ' + postalCode);
      console.log('Ville: ' + ville);
      console.log('Street Number: ' + streetNumber);
      console.log('Street Name: ' + streetName);
      console.log('Latitude: ' + lattitude);
      console.log('Longitude: ' + longitude);
      console.log('Place Id: ' + placeId);
      document.getElementById('department').value = department;
      document.getElementById('region').value = region;
      document.getElementById('zipcode').value = postalCode;
      document.getElementById('city').value = ville;
      document.getElementById('street_number').value = streetNumber;
      document.getElementById('street_name').value = streetName;
      document.getElementById('latitude').value = lattitude;
      document.getElementById('longitude').value = longitude;
      document.getElementById('place_id').value = placeId;


    } else {
      window.alert(
        'Please select a valid address that includes a department and region.',
      );
      document.getElementById('adresse').value = '';
    }
  });
}

document.querySelector("#pubHorsLigne").addEventListener("change", function () {
  if (this.checked) {
    document.querySelector("#btnPublier").textContent = "Enregistrer hors ligne";
  } else {
    document.querySelector("#btnPublier").textContent = "Publier";
  }
});

function submitForm(event){
  console.log(event.target);
  if (event.target.id == 'btnPublier') {
    document.querySelector("#publication").value = "publier";
    
  }
  else if (event.target.id == 'btnPrevisualiser') {
    document.querySelector("#publication").value = "previsualiser";
  }
}