let form = document.querySelector("form");
let formDiv = document.getElementById("formDiv");
let service = document.getElementById("reservation_service");
let midi = document.getElementById("reservation_midi");
let soir = document.getElementById("reservation_soir");
let nbCouverts = document.getElementById("reservation_nbCouverts");
let midiDiv = document.getElementById("midiDiv");
let soirDiv = document.getElementById("soirDiv");
let nbCouvertsDiv = document.getElementById("nbCouvertsDiv");
let fullAlert = document.getElementById("fullAlert");
let nbCouvertsPrefilled = document.getElementById("reservation_nbCouverts").value;
// let newReservationBottom = document.getElementById("newReservationBottom");

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


let nbCouvertsMax;
let nbCouvertsReservation;
let nbCouvertsRemain;
let isWarningDisplayed = false;
let warningParagraph;  

// Définir la fonction preventDefaultSubmit pour empêcher la soumission du formulaire.
function preventDefaultSubmit(event) {
  event.preventDefault();
}

// On va chercher le nb de couverts max et le nb de réservation total en base de donnée.
fetch("/nbCouvertsMax")
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    return response.json();
  })
  .then((data) => {
    nbCouvertsMax = data[0].maxCouverts;
    return fetch("/nbCouverts");
  })
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    return response.json();
  })
  .then((data) => {
    nbCouvertsReservation = data[0].nbCouverts;
    nbCouvertsRemain = nbCouvertsMax - nbCouvertsReservation;
    // console.log("Il reste:", nbCouvertsRemain, "places.");

    //Si le nb de couverts restant n'est pas > 0, on affiche le message d'alerte et on cache le formulaire. 
    if (!nbCouvertsRemain > 0) {
      fullAlert.style.display = "block";
      formDiv.style.display = "none";
    }

    //Si le nb de couverts restant - le nb de couvert pré-rempli sur le formulaire n'est pas > 0, 
    //on affiche le message d'alerte et on empêche la soumission du formulaire.
    if(!(nbCouvertsMax - nbCouvertsReservation - nbCouvertsPrefilled > 0)) {
      // Ajouter l'événement "submit" avec la fonction de rappel nommée
      form.addEventListener('submit', preventDefaultSubmit);
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

    //On écoute l'input nb de couverts et si la valeur rentré par le client et > au nb de couverts...
    //restant, on affiche le message d'alerte et on empêche la soumission du formulaire. 
    nbCouverts.addEventListener("input", function(event) {  
      if (event.target.value > nbCouvertsRemain) {

        // Ajouter l'événement "submit" avec la fonction de rappel nommée
        form.addEventListener('submit', preventDefaultSubmit);
        
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
    });
  })
  .catch((error) => {
    console.error("Fetch error:", error);
  });

  

