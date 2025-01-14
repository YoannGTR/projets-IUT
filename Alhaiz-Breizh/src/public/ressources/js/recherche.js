function initAutocomplete() {
    const input = document.getElementById('city-select');
    const options = {
        types: ['(cities)'],
        componentRestrictions: { country: 'fr' },
        strictBounds: true,
    };

    const autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();
        // Vous pouvez maintenant utiliser les informations de place pour vos besoins.
    });

    // Restreindre les résultats à la région de Bretagne
    const bounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(47.4, -4.9), // Sud-Ouest de la Bretagne
        new google.maps.LatLng(48.8, -1.2)  // Nord-Est de la Bretagne
    );
    autocomplete.setBounds(bounds);
}


// Fonction pour masquer toutes les sections sauf la première ligne
// Fonction pour masquer toutes les sections sauf la première ligne
function closeFilters() {
    const container = document.getElementById('container-filtre');
    const children = container.children;

    for (let i = 1; i < children.length; i++) {
        children[i].style.display = 'none';
    }
    // Revenir en haut de la page
    window.scrollTo(0, 0);
}

// Fonction pour afficher toutes les sections
function openFilters() {
    const container = document.getElementById('container-filtre');
    const children = container.children;
    if(innerWidth<1024){
        for (let i = 1; i < children.length; i++) {
            children[i].style.display = 'block';
        }
    }
    else{
        for (let i = 1; i < children.length-1; i++) {
            children[i].style.display = 'block';
        }
    }
    
}

// Attacher un événement au bouton pour fermer les filtres
document.querySelector('.close-filter').addEventListener('click', function() {
    closeFilters();
});

// Attacher un événement à la première ligne pour ouvrir les filtres s'ils sont fermés
document.querySelector('.first-ligne').addEventListener('click', function() {
    const container = document.getElementById('container-filtre');
    const children = container.children;
    let allClosed = true;

    // Vérifier si toutes les sections sont fermées
    for (let i = 1; i < children.length; i++) {
        if (children[i].style.display !== 'none') {
            allClosed = false;
            break;
        }
    }

    // Si toutes les sections sont fermées, les ouvrir
    if (allClosed) {
        openFilters();
    }
});

// Ajouter un écouteur pour surveiller les changements de taille de l'écran
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) { // Taille minimale pour laptop
        openFilters();

    }
    else if(window.innerWidth < 1024){
        closeFilters();
    }
});




function createCard(info){
    all_card=document.getElementById("all-card");
    let card = document.createElement("div");
    card.classList.add("card");
    let link = document.createElement("a");
    link.setAttribute("href","./logement.php?id="+info["logement_uuid"]); 
    let image = document.createElement("div");
    image.classList.add("card-image");
    image.innerHTML = "<img src="+info["url"]+" >";
    let body = document.createElement("div");
    body.classList.add("card-body");
    let title = document.createElement("div");
    title.classList.add("card-title");
    title.innerHTML = "<h3>"+info["title"]+"</h3>";
    let excerpt = document.createElement("div");
    excerpt.classList.add("card-excerpt");
    excerpt.innerHTML = "<p>"+info["city"]+", "+info["department"]+", France</p>";
    let last = document.createElement("div");
    last.classList.add("last-line");
    let avis = document.createElement("div");
    avis.classList.add("card-avis");
    avis.innerHTML = "<p><strong>"+info["price_ttc"]/100+"€</strong> /nuit</p>";
    let avis_icon = document.createElement("div");
    avis_icon.classList.add("card-avis-icon");
    avis_icon.innerHTML ="<img src=\"./ressources/assets/user.svg\" alt=\"Star Icon\"/><p>"+info["capacity"]+"</p>"
    link.append(image);
    body.appendChild(title);
    body.appendChild(excerpt);
    body.appendChild(last);
    last.appendChild(avis);
    last.appendChild(avis_icon);
    body.appendChild(last);
    link.append(body);
    card.appendChild(link)
    all_card.appendChild(card);

}

function fill_page(filtered){
    document.getElementById("all-card").innerHTML = "";
    for(let i=0; i<filtered.length; i++){
        createCard(filtered[i]);
    }
}

function updateInput(input){
    if(input.value<0){
        input.value=0;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if(innerWidth<1024){
        closeFilters();
    }
    const minInput = document.getElementById('min-price');
    if(minInput.value<0){
        minInput.value =0;
    }
    const maxInput = document.getElementById('max-price');
    const date_arrivee = document.getElementById('formDateDeb');
    const date_depart = document.getElementById('formDateFin');
    const cityInput = document.getElementById('city-select');
    const departmentSelect = document.querySelector('.select-departement');
    const travellersInput = document.getElementById('quantity');
    const choice = document.getElementById('filtre');

    function isDateUnavailable(logementId, datesIndisponibles, dateDebut, dateFin) {
        // Vérifier si le logement a des dates indisponibles définies
       if(datesIndisponibles[logementId].length ==0){
        return true;
       }
    
        // Si une des dates de l'intervalle est vide, retourner true
        if (dateDebut==="" || dateFin==="") {
            return true;
        }
    
        // Convertir les dates de l'intervalle en objets Date
        const start = new Date(dateDebut);
        const end = new Date(dateFin);
    
        // Vérifier chaque période d'indisponibilité pour le logement
        for (const indisponibilite of datesIndisponibles[logementId]) {
            const indispoStart = new Date(indisponibilite.start);
            const indispoEnd = new Date(indisponibilite.end);
    
            // Vérifier si l'intervalle de dates se chevauche avec la période d'indisponibilité
            if (!(end < indispoStart || start > indispoEnd)) {
                return false; // Il y a chevauchement, donc la date est indisponible
            }
        }
        return true; // Aucun chevauchement trouvé, donc la date est disponible
    }
    function sortByChoice(data, champ) {
        if(champ ==="prix-asc"){
            var order = "asc";
            var field = "price_ttc";
        }
        else if(champ ==="prix-desc"){
            var order = "desc";
            var field = "price_ttc";
                }
        else if(champ ==="nom-asc"){
            var order = "asc";
            var field = "title";
                }
        else if(champ ==="nom-desc"){
            var order = "desc";
            var field = "title"
;        }
        else if(champ ==="voy-asc"){
            var order = "asc";
            var field = "capacity"
;        }
        else if(champ ==="voy-desc"){
            var order = "desc";
            var field = "capacity"
;        }
if(field === "title"){
    return trierObjetsParCleCaractereParCaractere(data,field,order);
}
    return data.sort((a, b) => {
        let comparison = 0;

        if (typeof a[field] === 'string' && typeof b[field] === 'string') {
            const aValue = a[field].toLowerCase();
            const bValue = b[field].toLowerCase();
            if (aValue < bValue) {
                comparison = -1;
            } else if (aValue > bValue) {
                comparison = 1;
            }
        } else {
            if (a[field] < b[field]) {
                comparison = -1;
            } else if (a[field] > b[field]) {
                comparison = 1;
            }
        }

        return order === 'asc' ? comparison : -comparison;
    });

    }
    function trierObjetsParCleCaractereParCaractere(array, cle, ordre = 'asc') {
        return array.sort((a, b) => {
            let valeurA = a[cle];
            let valeurB = b[cle];
            let minLength = Math.min(valeurA.length, valeurB.length);
            
            for (let i = 0; i < minLength; i++) {
                if (valeurA.charCodeAt(i) < valeurB.charCodeAt(i)) {
                    return ordre === 'asc' ? -1 : 1;
                } else if (valeurA.charCodeAt(i) > valeurB.charCodeAt(i)) {
                    return ordre === 'asc' ? 1 : -1;
                }
            }
            
            // Si les préfixes sont identiques, la chaîne la plus courte vient en premier
            return ordre === 'asc' ? valeurA.length - valeurB.length : valeurB.length - valeurA.length;
        });
    }
    
    // Fonction pour appliquer les filtres
    function filterItems() {
        let filterded=logement;
        let res = {};
        for(let i=0; i<filterded.length; i++){
            res[filterded[i].logement_uuid] = [];
        }
        for(let i=0; i<date.length; i++){
            res[date[i].logement_uuid].push({start: date[i].start_date ,end: date[i].end_date});
        }
        const minPrice = parseFloat(minInput.value) || 0;
        const maxPrice = parseFloat(maxInput.value) || Infinity;
        const city = cityInput.value.toLowerCase().split(",")[0];
        const department = departmentSelect.value;
        const travellers = parseInt(travellersInput.value, 10) || 0;
        const date_start = date_arrivee.value || "";
        const date_end = date_depart.value || "";

        var filteredLogements = filterded.filter(filterded => {
            const matchesPrice = filterded.price_ttc >= minPrice*100 && filterded.price_ttc <= maxPrice*100;
            const matchesCity = filterded.city.toLowerCase().includes(city);
            const matchesDepartment = !department || filterded.department === department;
            const matchesTravellers = filterded.capacity >= travellers;
            const matchesTime = isDateUnavailable(filterded.logement_uuid, res, date_start, date_end);
            const isAvailable = filterded.state != "DISABLED";

            return matchesPrice && matchesCity && matchesDepartment && matchesTravellers && matchesTime && isAvailable;
        });

        if(choice.value!=""){
            filteredLogements = sortByChoice(filteredLogements,choice.value);
        }

        fill_page(filteredLogements);
    }

    // Fonction pour afficher les éléments filtrés
    // Écouteurs d'événements pour les champs de filtre
    [maxInput, minInput,cityInput, departmentSelect, travellersInput,date_arrivee,date_depart,choice].forEach(input => {
        input.addEventListener('input', filterItems);
    });
    [date_arrivee,date_depart].forEach(input => {
        input.addEventListener('change', filterItems);
    });
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                filterItems();
            }
        });
    });

    observer.observe(date_arrivee, {
        attributes: true // Observe attribute changes
    });
    observer.observe(date_depart, {
        attributes: true // Observe attribute changes
    });




    // Écouteurs d'événements pour les boutons plus et moins
    document.getElementById('plus').addEventListener('click', () => {
        let value = parseInt(travellersInput.value, 10) || 0;
        travellersInput.value = value + 1;
        filterItems();
    });

    document.getElementById('minus').addEventListener('click', () => {
        let value = parseInt(travellersInput.value, 10) || 0;
        if (value > 0) {
            travellersInput.value = value - 1;
            filterItems();
        }
    });

    // Appliquer les filtres au chargement de la page
    filterItems();
});

