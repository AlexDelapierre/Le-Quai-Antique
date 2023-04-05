let service = document.getElementById("reservation_service");
let midi = document.getElementById("reservation_midi");
let soir = document.getElementById("reservation_soir");
let midiDiv = document.getElementById("midiDiv");
let soirDiv = document.getElementById("soirDiv");
let nbCouvertsForm = document.getElementById("reservation_nbCouverts");

soir.disabled = true;

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

const url = Routing.generate("app_nbCouverts");
console.log(url);

/*
fetch("app_nbCouverts")
  .then((response) => {
    if (response.ok) {
      return response.json();
    } else {
      //Traitement de l'erreur dans la réponse
      console.error("Erreur réponse : " + response.status);
    }
  })
  .then((data) => {
    console.log(data);
  })
  .catch((error) => console.error(error)); //Traitement de l'erreur dans l'appel
  */

// const request = new Request(url, { method: "GET" });
