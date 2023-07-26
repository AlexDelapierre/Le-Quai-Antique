//-----------------On désactive le bouton submit lorsqu'un formulaire est soumis-------------------
const form = document.querySelector("form");

// On vérifie si un formulaire est présent sur la page
if (form !== null) {
  form.addEventListener('submit', function(event) {
    // Désactivez tous les boutons du formulaire
    document.querySelectorAll("button").forEach(function(button) {
      button.disabled = true;
    });
  });
};

// Pour ajouter dynamiquement la classe Bootstrap tableResponsive aux tables du panneau d'administration en format mobile
const tableResponsive = document.querySelector('.tableResponsive');

function setClass() {
  if (window.innerWidth > 992) {
    
    tableResponsive.classList.remove('table-responsive');
  } else {
    
    tableResponsive.classList.add('table-responsive');
  }
}

if (tableResponsive !== null) {
  window.addEventListener('resize', setClass);
  setClass(); 
}





