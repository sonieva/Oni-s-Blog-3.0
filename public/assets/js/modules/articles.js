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
              renderPagination(response.current_page, response.total_pages);
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
      if (currentPage > 1) {
          paginationContainer.append(`<button class="page-btn" data-page="${currentPage - 1}">Anterior</button>`);
      }
      for (let i = 1; i <= totalPages; i++) {
          paginationContainer.append(`
              <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>
          `);
      }
      if (currentPage < totalPages) {
          paginationContainer.append(`<button class="page-btn" data-page="${currentPage + 1}">Següent</button>`);
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
