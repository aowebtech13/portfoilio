/**
 * Axios API client for the A.O Webtech portfolio frontend.
 *
 * Loaded as a plain `<script>` (no bundler). Requires:
 *   1. env/env.js (or env/env.dev.js)  -> defines window.APP_ENV
 *   2. assets/js/axios.min.js          -> exposes window.axios
 *
 * Usage in pages:
 *
 *   <script src="env/env.js"></script>
 *   <script src="env/env.dev.js"></script>
 *   <script src="assets/js/axios.min.js"></script>
 *   <script src="assets/js/api.js"></script>
 *   <script src="assets/js/projects.js"></script>
 *
 * Then in any other script:
 *
 *   api.get('/projects').then(r => console.log(r.data));
 *
 * Or via the higher-level services:
 *
 *   api.projects.list().then(items => renderProjects(items));
 */
(function () {
  'use strict';

  if (typeof window === 'undefined') {
    throw new Error('api.js must be loaded in a browser context');
  }

  var env = window.APP_ENV;
  if (!env) {
    throw new Error(
      '[api.js] window.APP_ENV is missing. Load env/env.js before api.js.'
    );
  }

  if (typeof window.axios === 'undefined') {
    throw new Error(
      '[api.js] window.axios is missing. Load assets/js/axios.min.js before api.js.'
    );
  }

  // Pre-configured axios instance ----------------------------------------
  var instance = window.axios.create({
    baseURL: env.API_BASE_URL,
    timeout: env.REQUEST_TIMEOUT_MS || 15000,
    headers: Object.assign(
      {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      env.DEFAULT_HEADERS || {}
    )
  });

  // Request interceptor: attach bearer token if configured
  instance.interceptors.request.use(function (config) {
    if (env.AUTH_TOKEN) {
      config.headers = config.headers || {};
      config.headers.Authorization = 'Bearer ' + env.AUTH_TOKEN;
    }
    return config;
  });

  // Response interceptor: normalise Laravel error envelopes
  instance.interceptors.response.use(
    function (response) {
      if (env.DEBUG) {
        // eslint-disable-next-line no-console
        console.log(
          '[api] ' + response.config.method.toUpperCase() + ' ' +
            response.config.url + ' -> ' + response.status
        );
      }
      return response;
    },
    function (error) {
      if (env.DEBUG) {
        // eslint-disable-next-line no-console
        console.error(
          '[api] error',
          (error.config && error.config.url) || '(no url)',
          error.response && error.response.status,
          error.response && error.response.data
        );
      }
      // Re-throw so callers can use try/catch or .catch()
      return Promise.reject(error);
    }
  );

  // High-level domain services -----------------------------------------
  var services = {
    /**
     * Projects: list + show.
     * Mirrors backend routes in routes/api.php:
     *   GET /api/projects
     *   GET /api/projects/{slug}
     */
    projects: {
      list: function (params) {
        return instance.get('/projects', { params: params || {} }).then(function (r) {
          return r.data;
        });
      },
      show: function (slug) {
        return instance.get('/projects/' + encodeURIComponent(slug))
          .then(function (r) { return r.data; });
      }
    },

    /**
     * Contact form submission.
     * Mirrors backend route: POST /api/contact
     */
    contact: {
      submit: function (payload) {
        return instance.post('/contact', payload).then(function (r) {
          return r.data;
        });
      }
    },

    /**
     * Generic health check. Useful for the browser console / status pages.
     * GET /api/health
     */
    health: function () {
      return instance.get('/health').then(function (r) { return r.data; });
    }
  };

  // Public API ---------------------------------------------------------
  var api = {
    instance: instance,
    projects: services.projects,
    contact: services.contact,
    health: services.health,
    env: env,
    // Expose low-level helpers for one-off calls
    get: function (url, config) { return instance.get(url, config); },
    post: function (url, data, config) { return instance.post(url, data, config); },
    put: function (url, data, config) { return instance.put(url, data, config); },
    patch: function (url, data, config) { return instance.patch(url, data, config); },
    del: function (url, config) { return instance.delete(url, config); }
  };

  window.AOWEB = window.AOWEB || {};
  window.AOWEB.api = api;

  // Backwards-compatible default export so `import api from "./api"`
  // still works in any module-aware tooling that might be wired up later.
  window.api = api;
})();