<p align="center">
<img src="/public/images/librio-small.png"/>
</p>

# Librio Legacy

Librio is an open source library system, created for small libraries who don't want to invest in an expensive system.
This version is the initial idea and is deprecated.

## Technology stack

### Backend

- **PHP** 8.0+ (see `composer.json`)
- **Laravel** 9.x
- **Laratrust** (roles/permissions), **Laravel Collective** (forms), **Maatwebsite Excel** (exports), **Column sortable**, **Eloquent Filter**, **Laravel Money**, **Flash** messages, and other packages listed in `composer.json`

### Admin UI (CSS)

Bundled and compiled from **AdminLTE 2.4** (`resources/sass/app.scss`):

- **Bootstrap 3** (CSS from AdminLTE’s bundled `bootstrap.min.css`)
- **AdminLTE** layout and components
- **Font Awesome** 4 (via AdminLTE)
- **Ionicons**
- **Select2** (styles from AdminLTE bundle)
- **iCheck** and **Bootstrap Timepicker** (AdminLTE plugins)
- Custom skin: `resources/sass/skin-librio.scss`

Blade views use **Bootstrap 3-style markup** (e.g. `btn-group`, `ul.dropdown-menu`, `li > a`) so they match the compiled CSS.

### JavaScript

Loaded via `resources/js/bootstrap.js` and **Laravel Mix** (`webpack.mix.js`):

- **jQuery** 3.x
- **Bootstrap 4** JavaScript (npm `bootstrap` — used for dropdowns, modals, etc.) with **Popper.js** 1.x  
  Note: this is **not** the same major version as the Bootstrap 3 CSS above; components rely on markup that works with both (e.g. `data-toggle="dropdown"`).
- **AdminLTE** JS
- **Select2**, **Moment** (AdminLTE bundle), **Bootstrap Datepicker**, **Chartisan** + **Chart.js**, **Axios**, **Lodash**

### Front-end build

- **Laravel Mix** 2.x and **webpack** 3 (`npm run development` / `npm run production`)
- **Sass** sources under `resources/sass/` (Laravel Mix historically used `node-sass`; use a **Node** version compatible with your install, or replace with Dart `sass` if you hit native binding errors)

## Requirements

- **PHP** 8.0+ and extensions as in `composer.json` (`intl`, `json`, `mbstring`, …)
- **Composer** for PHP dependencies
- **Database** (e.g. MySQL, PostgreSQL, SQLite)
- **Web server** (e.g. Apache, Nginx, IIS)
- **Node.js** for front-end assets: prefer **18.x or 20.x LTS** with a recent **npm**. Older **webpack 3** builds may need `NODE_OPTIONS=--openssl-legacy-provider` on newer Node versions. **Node 14 or 16** can be easier for this toolchain without that flag.
