// Funció per gestionar el toggle de contrasenyes amb jQuery
export function initPasswordToggle() {
  $(document).on('click', '.toggle-password', function () {
      // Obté l'input associat mitjançant data-target
      const inputId = $(this).data('target');
      const $passwordInput = $('#' + inputId);

      if ($passwordInput.length) {
          const isPassword = $passwordInput.attr('type') === 'password';

          // Canvia el tipus d'input i l'icona
          $passwordInput.attr('type', isPassword ? 'text' : 'password');
          $(this)
              .toggleClass('fa-lock', !isPassword)
              .toggleClass('fa-unlock', isPassword)
              .attr('title', isPassword ? 'Ocultar contrasenya' : 'Mostrar contrasenya');
      }
  });
}
