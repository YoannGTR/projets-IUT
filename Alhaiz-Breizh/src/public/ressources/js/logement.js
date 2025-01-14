window.addEventListener('DOMContentLoaded', function () {
  document.getElementById('formQuantity').value = 1;
  if (capacity == 1) {
    document.getElementById('plusSvg').setAttribute('fill', '#f57393');
    document.getElementById('plus').style.backgroundColor = '#fff';
    document.getElementById('plus').style.cursor = 'auto';
  }
  document.getElementById('quantity').value = 1;
  //decrease the number of people
  document.getElementById('minus').addEventListener('click', function () {
    var quantity = parseInt(document.getElementById('quantity').value);
    if (quantity > 1) {
      quantity--;
      document.getElementById('quantity').value = quantity;
    }
    if (quantity == 1) {
      document.getElementById('minusSvg').setAttribute('fill', '#f57393');
      document.getElementById('minus').style.backgroundColor = '#fff';
      document.getElementById('minus').style.cursor = 'auto';
    }
    if (quantity < capacity) {
      document.getElementById('plusSvg').setAttribute('fill', '#fff');
      document.getElementById('plus').style.backgroundColor = '#f57393';
      document.getElementById('plus').style.cursor = 'pointer';
    }
    document.getElementById('formQuantity').value =
      document.getElementById('quantity').value;
  });

  //increase the number of people
  document.getElementById('plus').addEventListener('click', function () {
    var quantity = parseInt(document.getElementById('quantity').value);
    if (quantity == 1 && quantity < capacity) {
      document.getElementById('minusSvg').setAttribute('fill', '#fff');
      document.getElementById('minus').style.backgroundColor = '#f57393';
      document.getElementById('minus').style.cursor = 'pointer';
    }
    if (quantity < capacity) {
      quantity++;
      document.getElementById('quantity').value = quantity;
    }
    if (quantity == capacity) {
      document.getElementById('plusSvg').setAttribute('fill', '#f57393');
      document.getElementById('plus').style.backgroundColor = '#fff';
      document.getElementById('plus').style.cursor = 'auto';
    }
    document.getElementById('formQuantity').value =
      document.getElementById('quantity').value;
  });

  //check the format of the number when you leave the input
  document.getElementById('quantity').addEventListener('blur', function () {
    var quantity = parseInt(document.getElementById('quantity').value);
    if (Number.isNaN(quantity) || quantity <= 0 || quantity % 1 !== 0) {
      document.getElementById('quantity').value = 1;
    }
    var quantity = parseInt(document.getElementById('quantity').value);
    if (quantity > capacity) {
      document.getElementById('quantity').value = capacity;
    }
    if (quantity == 1) {
      document.getElementById('minusSvg').setAttribute('fill', '#f57393');
      document.getElementById('minus').style.backgroundColor = '#fff';
      document.getElementById('minus').style.cursor = 'auto';
    }
    if (quantity > 1) {
      document.getElementById('minusSvg').setAttribute('fill', '#fff');
      document.getElementById('minus').style.backgroundColor = '#f57393';
      document.getElementById('minus').style.cursor = 'pointer';
    }
    if (quantity == capacity) {
      document.getElementById('plusSvg').setAttribute('fill', '#f57393');
      document.getElementById('plus').style.backgroundColor = '#fff';
      document.getElementById('plus').style.cursor = 'auto';
    }
    if (quantity < capacity) {
      document.getElementById('plusSvg').setAttribute('fill', '#fff');
      document.getElementById('plus').style.backgroundColor = '#f57393';
      document.getElementById('plus').style.cursor = 'pointer';
    }
    document.getElementById('formQuantity').value =
      document.getElementById('quantity').value;
  });

  //check the format of the number when you change the input
  document.getElementById('quantity').addEventListener('input', function (e) {
    const regex = /\D/gi;
    e.target.value = e.target.value.replace(regex, '');
    var quantity = parseInt(document.getElementById('quantity').value);
    if (quantity > capacity) {
      document.getElementById('quantity').value = capacity;
    }
    if (quantity <= 1) {
      document.getElementById('minusSvg').setAttribute('fill', '#f57393');
      document.getElementById('minus').style.backgroundColor = '#fff';
      document.getElementById('minus').style.cursor = 'auto';
    }
    if (quantity > 1) {
      document.getElementById('minusSvg').setAttribute('fill', '#fff');
      document.getElementById('minus').style.backgroundColor = '#f57393';
      document.getElementById('minus').style.cursor = 'pointer';
    }
  });
});
//verif if the input is empty
function verif() {
  var inputs = document.getElementsByClassName('formInput');
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].value == '') {
      console.log('Veuillez remplir tous les champs !');
      document.getElementsByClassName('table-calendar')[0].style.border =
        '2px solid red';
      document.getElementById('CalendarVide').style.display = 'inline-block';
      return false;
    }
  }
  document.getElementsByClassName('table-calendar')[0].style.border = 'none';
  document.getElementById('CalendarVide').style.display = 'none';
  document.getElementById('btnReserver').classList.add('redirect');
  return true;
}

var longsTexte = {};
const longMax = 500;

checkLongueur(document.getElementsByClassName('longTexte')[0]);

//check the length of the text
function checkLongueur(elemText) {
  if (elemText.innerText.length > longMax) {
    let cloneElemText = elemText.cloneNode(true);
    longsTexte[cloneElemText.id] = cloneElemText;
    voirMoins(elemText);
  }
}
//see more text
function voirPlus(elemText) {
  console.log(elemText);
  let cloneElemText = longsTexte[elemText.id];
  elemText.innerHTML = cloneElemText.innerHTML;
  elemText.innerHTML +=
    "  <button class='voirMoins' onclick='voirMoins(this.parentElement)'>Voir moins</button>";
}
//see less text
function voirMoins(elemText) {
  elemText.innerText = elemText.innerText.substring(0, longMax) + '...';
  if (elemText.innerText[longMax - 1] == ' ') {
    elemText.innerText = elemText.innerText.substring(0, longMax - 1) + '...';
  }
  elemText.innerHTML +=
    "  <button class='voirPlus' onclick='voirPlus(this.parentElement)'>Voir plus</button>";
}
