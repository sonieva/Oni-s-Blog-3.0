export class TabsManager {
  constructor(containerSelector, tabHeadClass = 'tab-head', tabContentClass = 'tab-content', errorClass = 'errors') {
      this.$container = $(containerSelector);
      if (!this.$container.length) {
          throw new Error(`Container not found: ${containerSelector}`);
      }

      this.$tabHeads = this.$container.find(`.${tabHeadClass}`);
      this.$tabContents = this.$container.find(`.${tabContentClass}`);
      this.errorClass = errorClass;

      // Guardar el contenido original de la pestaña "change-password"
      this.changePasswordContent = this.$container.find('#change-password').html();

      // Inicializar eventos
      this.initTabs();
  }

  initTabs() {
      this.$tabHeads.on('click', (event) => {
          const $clickedTab = $(event.currentTarget);
          this.switchTab($clickedTab);
      });

      // Configurar el estado inicial
      this.handleInitialTabState();
  }

  handleInitialTabState() {
      const activeTab = this.$tabHeads.filter('.active').data('tab');
      if (activeTab !== 'change-password') {
          this.removeChangePasswordContent();
          this.$container.find(`.${this.errorClass}`).remove();
      }
  }

  switchTab($selectedTab) {
      const targetContentId = $selectedTab.data('tab');

      // Desactivar todos los encabezados y contenidos
      this.$tabHeads.removeClass('active');
      this.$tabContents.removeClass('active');

      // Activar el encabezado y contenido seleccionados
      $selectedTab.addClass('active');
      const $targetContent = this.$container.find(`#${targetContentId}`);
      if ($targetContent.length) {
          $targetContent.addClass('active');
      } else {
          console.error(`Content not found for tab: ${targetContentId}`);
      }

      // Quitar los divs con la clase 'errors'
      this.$container.find(`.${this.errorClass}`).remove();
      
      // Manejar el contenido de "change-password"
      if (targetContentId === 'change-password') {
          this.restoreChangePasswordContent();
      } else {
          this.removeChangePasswordContent();
      }
  }

  removeChangePasswordContent() {
      const $changePasswordTab = this.$container.find('#change-password');
      $changePasswordTab.empty(); // Eliminar todo el contenido
  }

  restoreChangePasswordContent() {
      const $changePasswordTab = this.$container.find('#change-password');
      if ($changePasswordTab.is(':empty')) {
          $changePasswordTab.html(this.changePasswordContent); // Restaurar el contenido original
          this.$container.find(`.${this.errorClass}`).remove();
      }
  }
}
