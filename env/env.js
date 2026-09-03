/**
 * Frontend Environment Configuration
 * ----------------------------------
 * This file is the SINGLE source of truth for runtime config on the client.
 *
 * For a no-build vanilla-JS setup, "env variables" are simply values defined
 * here and exposed on `window.APP_ENV`. Pick the file you want to load via
 * `<script src="env/env.js">` (defaults) or `<script src="env/env.dev.js">`
 * (development override) BEFORE `assets/js/api.js`.
 *
 * In a real build pipeline (Vite, webpack, Next.js, etc.) you would replace
 * these values with `import.meta.env.VITE_*` or `process.env.*`. The shape
 * of `window.APP_ENV` mirrors what a build tool would inject so the rest of
 * the app code does not need to change.
 */
(function () {
  'use strict';

  var DEFAULT_ENV = {
    // API base URL (Laravel backend)
    API_BASE_URL: 'http://localhost:8000/api',

    // Frontend base URL (for building absolute links / sharing)
    FRONTEND_URL: 'http://localhost:5500',

    // Backend base URL (for linking to admin, files, etc.)
    BACKEND_URL: 'http://localhost:8000',

    // Default request timeout in milliseconds
    REQUEST_TIMEOUT_MS: 15000,

    // Toggle extra console logging from the api client
    DEBUG: true,

    // Default headers
    DEFAULT_HEADERS: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },

    // Optional: bearer token (leave empty for public endpoints)
    AUTH_TOKEN: ''
  };

  // Allow runtime override: `window.APP_ENV_OVERRIDE = { ... }` set before
  // this script runs (e.g. injected by the host page or a dev panel).
  var userOverride = (typeof window !== 'undefined' && window.APP_ENV_OVERRIDE) || {};

  window.APP_ENV = Object.assign({}, DEFAULT_ENV, userOverride);

  // Also expose on a single global namespace for convenience.
  window.AOWEB = window.AOWEB || {};
  window.AOWEB.env = window.APP_ENV;
})();