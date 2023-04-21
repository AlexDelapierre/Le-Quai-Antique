
// Pour ajouter dynamiquement la classe Bootstrap col-6 à la balise sections des tables de l'interface administrateur
const tableSection = document.querySelector('#tableSection');
const tableResponsive = document.querySelector('.tableResponsive');

function setClass() {
  if (window.innerWidth > 992) {
    tableSection.classList.add('col-6');
    tableResponsive.classList.remove('table-responsive');
  } else {
    tableSection.classList.remove('col-6');
    tableResponsive.classList.add('table-responsive');
  }
}

window.addEventListener('resize', setClass);
setClass();


