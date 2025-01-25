import { initUserDropdown } from './components/userDropdown.js';
import { initPasswordToggle } from './components/passwordToggle.js';
import { AliasChecker } from './components/aliasChecker.js';
import { ArticlesModule } from './modules/articles.js';
import { TabsManager } from './components/tabsManager.js';
import { ArticleCounter } from './components/articleCounter.js';
import { UsersList } from './components/usersList.js';

// Inicialitzar el dropdown d'usuari quan es carrega la pàgina
$(document).ready(function () {
  initUserDropdown();
  initPasswordToggle();

  const currentPath = window.location.pathname;

  if (currentPath === '/register') {
    // new AliasChecker(
    //   '#alies-register-input',
    //   '#alies-register-status',
    //   '#alias-register-status-msg',
    //   '/api/check-alies.php'
    // );
  } else if (currentPath === '/') {
    ArticlesModule({
      articlesContainerId: 'articles-container',
      paginationContainerId: 'pagination',
      searchInputId: 'search-input',
      articlesPerPageSelectId: 'articles-per-page',
      sortSelectId: 'sort-select',
      spinnerId: 'loading-spinner',
      apiEndpoint: '/api/articles'
    });
  } else if (currentPath === '/admin') {
    new UsersList(
      "/api/users", // URL de la API
      ".users-list-content", // Selector del contenedor de tarjetas
      "#user-counter" // Selector del contador
    );
  } else if (currentPath === '/profile') {
    new TabsManager(
      '.profile-container',
      'tab-head',
      'tab-content'
    );
    new ArticleCounter('/api/articles');
  }
});
