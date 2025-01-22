import { initUserDropdown } from './components/userDropdown.js';
import { initPasswordToggle } from './components/passwordToggle.js';
import { AliasChecker } from './components/aliasChecker.js';
import { ArticlesModule } from './modules/articles.js';

// Inicialitzar el dropdown d'usuari quan es carrega la pàgina
$(document).ready(function () {
  initUserDropdown();
  initPasswordToggle();
  // new AliasChecker(
  //   '#alies-register-input',
  //   '#alies-register-status',
  //   '#alias-register-status-msg',
  //   '/api/check-alies.php'
  // );
  ArticlesModule({
    articlesContainerId: 'articles-container',
    paginationContainerId: 'pagination',
    searchInputId: 'search-input',
    articlesPerPageSelectId: 'articles-per-page',
    sortSelectId: 'sort-select',
    spinnerId: 'loading-spinner',
    apiEndpoint: '/api/articles'
  });
});
