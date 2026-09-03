/**
 * Production Environment Configuration
 * -------------------------------------
 * Override values for production. Replace the URLs with your real
 * production backend and frontend hosts before deploying.
 *
 * Usage in HTML:
 *   <script src="env/env.js"></script>
 *   <script src="env/env.prod.js"></script>
 *   <script src="assets/js/axios.min.js"></script>
 *   <script src="assets/js/api.js"></script>
 */
(function () {
  'use strict';

  window.APP_ENV_OVERRIDE = Object.assign(window.APP_ENV_OVERRIDE || {}, {
    API_BASE_URL: 'https://api.your-domain.com/api',
    FRONTEND_URL: 'https://your-domain.com',
    BACKEND_URL: 'https://api.your-domain.com',
    DEBUG: false
  });
})();