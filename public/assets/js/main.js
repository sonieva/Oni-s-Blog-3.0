import { initUserDropdown } from './components/userDropdown.js';
import { initPasswordToggle } from './components/passwordToggle.js';

// Inicialitzar el dropdown d'usuari quan es carrega la pàgina
$(document).ready(function () {
  initUserDropdown();
  initPasswordToggle();

  // Evitar icones en els camps de text i password posades per defecte pels navegadors
  $('input[type="text"], input[type="password"]').css('background-image', 'none'); 
});
