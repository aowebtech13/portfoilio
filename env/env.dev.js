/**
 * Development Environment Configuration
 * --------------------------------------
 * Load this AFTER env/env.js (or instead of it) to override values for local
 * development. Useful when you run Laravel on a different port, or want extra
 * logging.
 *
 * Usage in HTML:
 *   <script src="env/env.js"></script>
 *   <script src="env/env.dev.js"></script>
 *   <script src="assets/js/axios.min.js"></script>
 *   <script src="assets/js/api.js"></script>
 */
(function () {
  'use strict';

  window.APP_ENV_OVERRIDE = Object.assign(window.APP_ENV_OVERRIDE || {}, {
    API_BASE_URL: 'http://localhost:8000/api',
    FRONTEND_URL: 'http://localhost:5500',
    BACKEND_URL: 'http://localhost:8000',
    DEBUG: true
  });
})();