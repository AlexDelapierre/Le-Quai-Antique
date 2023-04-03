let service = document.getElementById("reservation_service");
let midi = document.getElementById("reservation_midi");
let soir = document.getElementById("reservation_soir");
let midiDiv = document.getElementById("midiDiv");
let soirDiv = document.getElementById("soirDiv");

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
