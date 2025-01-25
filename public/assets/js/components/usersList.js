export class UsersList {
  constructor(apiUrl, userListContentSelector, userCounterSelector) {
    this.apiUrl = apiUrl; // URL de la API para obtener usuarios
    this.$userListContent = $(userListContentSelector); // Contenedor de las tarjetas
    this.$userCounter = $(userCounterSelector); // Contenedor del contador de usuarios

    // Carga los usuarios al inicializar la clase
    this.fetchUsers();
  }

  // Método para renderizar usuarios
  renderUsers(users) {
    this.$userListContent.empty(); // Limpia el contenido previo
    users.forEach(user => {
      const userCard = `
        <div class="user-card">
          <div class="user-card-info">
            <img src="${user.img_path || 'assets/img/default-user.png'}" alt="${user.full_name}" class="user-avatar">
            <div class="user-details">
              <span class="user-nickname">${user.nickname}</span>
              <span class="user-fullname">${user.full_name || ''}</span>
              <span class="user-email">${user.email}</span>
            </div>
          </div>
          <div class="user-actions">
            <button class="btn-make-admin" data-id="${user.id}" title="Fer admin">
              <img src="assets/icons/user-security.svg" alt="Fer admin">
            </button>
            <button class="btn-delete-user" data-id="${user.id}" title="Eliminar usuari">
              <img src="assets/icons/trash.svg" alt="Eliminar usuari">
            </button>
          </div>
        </div>
      `;
      this.$userListContent.append(userCard);
    });

    // Actualiza el contador de usuarios
    this.$userCounter.text(users.length);
  }

  // Método para cargar usuarios desde la API
  fetchUsers() {
    $.ajax({
      url: this.apiUrl,
      method: "GET",
      dataType: "json",
      success: (data) => {
        this.renderUsers(data);
      },
      error: (xhr, status, error) => {
        console.error("Error fetching users:", error);
      },
    });
  }
}
