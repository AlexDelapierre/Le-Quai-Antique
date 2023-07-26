let form = document.querySelector("form");
let formDiv = document.getElementById("formDiv");
let date = document.getElementById("reservation_date");
let service = document.getElementById("reservation_service");
let midi = document.getElementById("reservation_midi");
let soir = document.getElementById("reservation_soir");
let midiDiv = document.getElementById("midiDiv");
let soirDiv = document.getElementById("soirDiv");
let nbCouverts = document.getElementById("reservation_nbCouverts");
let nbCouvertsValue = document.getElementById("reservation_nbCouverts").value;
let nbCouvertsDiv = document.getElementById("nbCouvertsDiv");


//On désactive le champ soir de base
soir.disabled = true;

//Pour afficher ou cacher les créneaux midi ou soir en fonction de la séléction du service.
service.addEventListener("change", (event) => {
  if (event.target.value === "midi") {
    midiDiv.style.display = "block";
    soirDiv.style.display = "none";
    midi.disabled = false;
    soir.disabled = true;
  } else {
    soirDiv.style.display = "block";
    midiDiv.style.display = "none";
    midi.disabled = true;
    soir.disabled = false;
  }
});

// On défini les variables
let nbCouvertsMax;
let nbCouvertsReservation;
let nbCouvertsRemain;
let isWarningDisplayed = false;
let warningParagraph;  


// On défini la fonction preventDefaultSubmit pour empêcher la soumission du formulaire.
function preventDefaultSubmit(event) {
  event.preventDefault();
}


//--------------------------------On écoute le champ date-------------------------------
date.addEventListener("input", function(event) {
  // Si il y a un message d'alerte déjà présent, on le supprime
  if(isWarningDisplayed && warningParagraph) {
    warningParagraph.remove();
    isWarningDisplayed = false;
  };
  // Si la valeur du champ nbCouvert n'est pas null, on déclanche l'événement nbCouverts
  if(nbCouvertsValue != null) {
    nbCouverts.dispatchEvent(new Event('input'));   
  };
});


//--------------------------------On écoute le champ service-------------------------------
service.addEventListener("input", function(event) {
  // Si il y a un message d'alerte déjà présent, on le supprime
  if(isWarningDisplayed && warningParagraph) {
    warningParagraph.remove();
    isWarningDisplayed = false;
  };

  // Si la valeur du champ nbCouvert n'est pas null, on déclanche l'événement nbCouverts
  if(nbCouvertsValue != null) {
    nbCouverts.dispatchEvent(new Event('input'));  
  };
});

  
//--------------------------------On écoute le champ nbCouverts-------------------------------
// On écoute le champ nbCouvert et si les champs date et service on été rempli, on envoie la requête fetch avec les données.
// Sinon, on empêche la soumission du formulaire et on affiche le message d'alerte : "Vous devez indiquer une date !" 

//On attend le retour des requêtes fetch et si la valeur rentrée par le client est > au nb de places 
//restantes, on affiche le message d'alerte et on empêche la soumission du formulaire. 
nbCouverts.addEventListener("input", function(event) {

  let dateValue = document.getElementById("reservation_date").value;
  let serviceValue = document.getElementById("reservation_service").value;

  //On s'assure que les champs date et service ont été rempli avant d'envoyer les 2 requêtes fetch :
  if(dateValue && serviceValue != null) {
    
    // 1-On va chercher le nb de couverts max en base de donnée.
    fetch("/nbCouvertsMax") 
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      //On récupère le nb de couvert max :
      nbCouvertsMax = data[0].maxCouverts;

      //On défini les données à envoyer dans la 2ème méthode fetch.
      const bodyData = new FormData();
      bodyData.append('date', dateValue);
      bodyData.append('service', serviceValue);

      // console.log(bodyData.get('date'))

      // 2-On va chercher le nb de réservation total en fonction de la date et du service sélectionné en base de donnée.
      return fetch("/nbCouverts", { 
        method: 'POST',
        body: bodyData
      });
    })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      //On récupère le nb de réservation total :
      nbCouvertsReservation = data[0].nbCouverts;
      //On calcul le nb de couverts restant :
      nbCouvertsRemain = nbCouvertsMax - nbCouvertsReservation;
      console.log("Il reste:", nbCouvertsRemain, "places.");
    

      //Si la valeur du champ nbCouvert rentré par le client et > au nb de couverts restant, 
      // on affiche le message d'alerte avec le nb de couverts restant et on empêche la soumission du formulaire. 
      if (event.target.value > nbCouvertsRemain) {
        // On empêche la soumission du formulaire avec la fonction de rappel nommée.
        form.addEventListener('submit', preventDefaultSubmit);
        
        //Si le message d'alerte n'est pas déja affiché, on le crée et on l'ajoute au DOM.
        //Sinon on il supprime.
        if(!isWarningDisplayed) {
          warningParagraph = document.createElement('p');
          if (nbCouvertsRemain === 1){
            warningParagraph.innerText = `Nous sommes désolé, il ne reste plus que ${nbCouvertsRemain} place !`;
          } else if (nbCouvertsRemain !== 0) {
            warningParagraph.innerText = `Nous sommes désolé, il ne reste plus que ${nbCouvertsRemain} places !`; 
          } else {
            warningParagraph.innerText = "Nous sommes désolé, il ne reste plus de places !";
          }
          warningParagraph.style.color = "red";
          nbCouvertsDiv.append(warningParagraph);
          isWarningDisplayed = true;
        }
      } else {
        // Supprimer l'événement "submit" avec la même fonction de rappel nommée
        form.removeEventListener('submit', preventDefaultSubmit); 

        if (isWarningDisplayed) {
          warningParagraph.remove();
          isWarningDisplayed = false;
        }
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
  } else {
    // On affiche le message d'alerte : 
    if(!isWarningDisplayed) {
      warningParagraph = document.createElement('p');
      warningParagraph.innerText = "Vous devez indiquer une date !";
      warningParagraph.style.color = "red";
      nbCouvertsDiv.append(warningParagraph);
      isWarningDisplayed = true;
     } //else {
    //   warningParagraph.remove();
    //     isWarningDisplayed = false;
    // }    
    // On empêche la soumission du formulaire.
    form.addEventListener('submit', preventDefaultSubmit);
  }
  
});

