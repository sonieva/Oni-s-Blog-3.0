export class AliasChecker {
  constructor(inputSelector, statusIconSelector, statusMsgSelector, apiEndpoint) {
    // Selección de elementos con jQuery
    this.$input = $(inputSelector);
    this.$statusIcon = $(statusIconSelector);
    this.$statusMessage = $(statusMsgSelector);
    this.apiEndpoint = apiEndpoint;

    // Validar si los elementos existen
    if (!this.$input.length || !this.$statusIcon.length || !this.$statusMessage.length) {
      console.error('AliasChecker: uno o más elementos HTML no fueron encontrados.');
      return;
    }

    // Agregar eventos
    this.initEvents();
  }

  initEvents() {
    const debounceFunc = this.debounce(this.checkAliasAvailability.bind(this), 300);

    this.$input.on('input', debounceFunc);
    this.$input.on('blur', this.hideStatus.bind(this));
    this.$input.on('keypress', (e) => {
      if (e.key === 'Enter') {
        this.hideStatus();
      }
    });
  }

  async checkAliasAvailability() {
    const alias = this.$input.val().trim();

    // Mostrar icono de carga mientras se verifica
    this.$statusIcon
      .attr('class', 'status-icon loading-icon fas fa-spinner')
      .css('display', 'inline-block');

    if (alias === '') {
      this.hideStatus();
      return;
    }

    try {
      const available = await this.fetchAliasAvailability(alias);

      if (available) {
        // Alias disponible
        this.$statusIcon
          .attr('class', 'status-icon fas fa-check-circle')
          .css('color', 'green');
        this.$statusMessage
          .text('Alias disponible')
          .attr('class', 'texto-disponible');
      } else {
        // Alias no disponible
        this.$statusIcon
          .attr('class', 'status-icon fas fa-times-circle')
          .css('color', 'red');
        this.$statusMessage
          .text('Alias no disponible')
          .attr('class', 'texto-no-disponible');
      }
    } catch (error) {
      console.error('Error al verificar el alias:', error);
      this.hideStatus();
    }
  }

  async fetchAliasAvailability(alias) {
    try {
      const response = await $.ajax({
        url: this.apiEndpoint,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ alias }),
      });
      return response.disponible;
    } catch (error) {
      console.error('Error en la solicitud al servidor:', error);
      return false;
    }
  }

  hideStatus() {
    this.$statusIcon.css('display', 'none');
    this.$statusMessage.text('');
  }

  debounce(func, delay) {
    let timer;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
    };
  }
}
