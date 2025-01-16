// Funció per gestionar el dropdown del menú d'usuari amb jQuery
export function initUserDropdown() {
  $(document).on('click', '#dropdown-toggle', function (event) {
      event.stopPropagation();  // Evita que es tanqui immediatament

      const $dropdownMenu = $('#dropdown');
      const $caretIcon = $('#caret');

      // Alterna la visibilitat del dropdown
      $dropdownMenu.toggleClass('active');

      // Canvia la direcció de la icona
      $caretIcon.toggleClass('fa-caret-left fa-caret-down');
  });

  // Tanca el dropdown si es clica fora
  $(document).on('click', function (event) {
      const $dropdownMenu = $('#dropdown');
      const $caretIcon = $('#caret');

      if ($dropdownMenu.hasClass('active')) {
          $dropdownMenu.removeClass('active');
          $caretIcon.removeClass('fa-caret-down').addClass('fa-caret-left');
      }
  });
}
