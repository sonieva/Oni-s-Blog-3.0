export function ArticlesModule(config) {
  const {
      articlesContainerId,
      paginationContainerId,
      searchInputId,
      articlesPerPageSelectId,
      sortSelectId,
      spinnerId,
      apiEndpoint
  } = config;

  const articlesContainer = $(`#${articlesContainerId}`);
  const paginationContainer = $(`#${paginationContainerId}`);
  const loadingSpinner = $(`#${spinnerId}`);
  const searchInput = $(`#${searchInputId}`);
  const articlesPerPageSelect = $(`#${articlesPerPageSelectId}`);
  const sortSelect = $(`#${sortSelectId}`);

  let currentPage = 1;
  let articlesPerPage = 8;
  let sort = 'recent';
  let searchQuery = '';

  function loadArticles() {
      loadingSpinner.show();
      articlesContainer.empty();
      paginationContainer.empty();

      $.ajax({
          url: apiEndpoint,
          method: 'GET',
          data: {
              page: currentPage,
              limit: articlesPerPage,
              sort: sort,
              search: searchQuery
          },
          dataType: 'json',
          success: function (response) {
              loadingSpinner.hide();
              renderArticles(response.articles);
              renderPagination(response.currentPage, response.totalPages);
          },
          error: function (xhr) {
              console.error('Error al cargar los artículos:', xhr.responseText);
              loadingSpinner.hide();
          }
      });
  }

  function renderArticles(articles) {
      if (articles.length === 0) {
          articlesContainer.html('<p>No hi ha articles disponibles.</p>');
          return;
      }
      articles.forEach(article => {
          articlesContainer.append(`
              <div class="article">
                  <h2>${article.title}</h2>
                  <p>${article.body.substring(0, 150)}...</p>
                  <a href="/article/${article.id}">Llegir més</a>
              </div>
          `);
      });
  }

  function renderPagination(currentPage, totalPages) {
    paginationContainer.empty(); // Limpia el contenedor antes de agregar contenido

    // Primera página
    if (currentPage > 3) {
        paginationContainer.append(`<button class="page-btn" data-page="1">1</button>`);
        if (currentPage > 4) {
            paginationContainer.append('<span class="pagination-dots">...</span>');
        }
    }

    // Páginas cercanas al actual (máximo 2 antes y 2 después)
    const startPage = Math.max(2, currentPage - 2);
    const endPage = Math.min(totalPages - 1, currentPage + 2);

    for (let i = startPage; i <= endPage; i++) {
        paginationContainer.append(`
            <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>
        `);
    }

    // Última página
    if (currentPage < totalPages - 2) {
        if (currentPage < totalPages - 3) {
            paginationContainer.append('<span class="pagination-dots">...</span>');
        }
        paginationContainer.append(`<button class="page-btn" data-page="${totalPages}">${totalPages}</button>`);
    }
  }




  // Eventos
  $(`#search-button`).on('click', function () {
      searchQuery = searchInput.val();
      currentPage = 1;
      loadArticles();
  });

  articlesPerPageSelect.on('change', function () {
      articlesPerPage = $(this).val();
      currentPage = 1;
      loadArticles();
  });

  sortSelect.on('change', function () {
      sort = $(this).val();
      currentPage = 1;
      loadArticles();
  });

  paginationContainer.on('click', '.page-btn', function () {
      currentPage = parseInt($(this).data('page'));
      loadArticles();
  });

  // Inicialización
  loadArticles();
}
