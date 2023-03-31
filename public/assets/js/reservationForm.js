let link = document.getElementById("service");
let midiDiv = document.getElementById("midiDiv");
let soirDiv = document.getElementById("soirDiv");
let midi = document.getElementById("midi");
let soir = document.getElementById("soir");
let fullAlert = document.getElementById("fullAlert");

soir.disabled = true;

link.addEventListener("change", (event) => {
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
