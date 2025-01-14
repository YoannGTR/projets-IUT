function accepter(id) {
    window.location.href = "/paiement.php?id=" + id;
}

function refuser() {
    window.location.href = "/";
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
