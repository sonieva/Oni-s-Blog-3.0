export class ArticleCounter {
  constructor(endpointUrl, nicknameElementId = 'user-nickname', counterElementId = 'article-counter') {
      this.endpointUrl = endpointUrl; // Base URL del endpoint
      this.$nicknameElement = document.getElementById(nicknameElementId);
      this.$counterElement = document.getElementById(counterElementId);

      // Validar elementos en la inicialización
      if (!this.$nicknameElement) {
          throw new Error(`Nickname element not found with ID: ${nicknameElementId}`);
      }
      if (!this.$counterElement) {
          throw new Error(`Counter element not found with ID: ${counterElementId}`);
      }

      this.fetchArticles();
  }

  async fetchArticles() {
      const nickname = this.$nicknameElement.textContent.trim();
      if (!nickname) {
          console.error('User nickname is empty.');
          return;
      }

      const url = `${this.endpointUrl}/author/${encodeURIComponent(nickname)}`;

      try {
          const response = await fetch(url);
          if (!response.ok) {
              throw new Error(`Failed to fetch articles. Status: ${response.status}`);
          }

          const articles = await response.json();
          this.updateCounter(articles.length); // Actualizar el contador con la cantidad de artículos
      } catch (error) {
          console.error('Error fetching articles:', error);
          this.updateCounter(0); // Mostrar 0 si hay un error
      }
  }

  updateCounter(count) {
      this.$counterElement.textContent = count;
  }
}
