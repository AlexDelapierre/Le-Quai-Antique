
// Pour ajouter dynamiquement la classe Bootstrap tableResponsive aux tables du panneau d'administration en format mobile
const tableResponsive = document.querySelector('.tableResponsive');

function setClass() {
  if (window.innerWidth > 992) {
    
    tableResponsive.classList.remove('table-responsive');
  } else {
    
    tableResponsive.classList.add('table-responsive');
  }
}

window.addEventListener('resize', setClass);
setClass();


