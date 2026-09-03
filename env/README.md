# Frontend env

This folder holds the frontend's environment configuration. The frontend is
plain HTML/JS (no build pipeline), so environment "variables" are simple
JavaScript files that set values on `window.APP_ENV`.

## Files

| File             | Purpose                                       |
|------------------|-----------------------------------------------|
| `env.js`         | Default values (used in every environment).   |
| `env.dev.js`     | Overrides for local development.               |
| `env.prod.js`    | Overrides for production.                     |
| `.env.example`   | Reference/documentation for env keys.         |

## Loading order in HTML

Always load `env.js` first, then any override file (`env.dev.js` or
`env.prod.js`), then axios, then your own scripts:

```html
<script src="env/env.js"></script>
<script src="env/env.dev.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="assets/js/api.js"></script>
<script src="assets/js/projects.js"></script>
```

`window.APP_ENV` is then available everywhere:

```js
console.log(window.APP_ENV.API_BASE_URL);
// -> http://localhost:8000/api
```

## Migrating to a build pipeline

If you later add Vite, webpack, Next.js, etc.:

* Replace the `<script>` tags with `import` statements.
* Replace `window.APP_ENV.API_BASE_URL` with `import.meta.env.VITE_API_BASE_URL`.
* Keep the shape (`API_BASE_URL`, `FRONTEND_URL`, `BACKEND_URL`, `DEBUG`,
  `AUTH_TOKEN`) so application code does not have to change.