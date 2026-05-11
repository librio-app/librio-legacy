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
- **`package.json` scripts** set `NODE_OPTIONS=--openssl-legacy-provider` so webpack 3 runs on **Node 17+** (OpenSSL 3 no longer supports the hashing webpack 3 uses by default).
- **Sass:** the **`sass`** devDependency plus an **`overrides`** rule replace **`node-sass`** (from Laravel Mix) with **Dart Sass**, because native `node-sass` bindings do not support current Node releases. Use **npm 8.3+** (or another client that applies `overrides`). Run **`npm install`** after pulling dependency changes, then build.
- **Switching Node versions:** use **[nvm](https://github.com/nvm-sh/nvm)** (or **fnm**, **asdf**, etc.) to install and try different releases. In the repo root, **`nvm install`** / **`nvm use`** picks up **`.nvmrc`** (suggested **Node 20**). Examples: `nvm install 18 && nvm use 18`, `nvm install 22 && nvm use 22`, then `npm install` and `npm run production` again.

## Requirements

- **PHP** 8.0+ and extensions as in `composer.json` (`intl`, `json`, `mbstring`, …)
- **Composer** for PHP dependencies
- **Database** (e.g. MySQL, PostgreSQL, SQLite)
- **Web server** (e.g. Apache, Nginx, IIS)
- **Node.js** for front-end assets: **18.x / 20.x / 22.x** with **npm 8.3+** matches the current `package.json` (scripts + overrides). The **`.nvmrc`** file suggests **20** for local builds. Without those `package.json` conveniences, use older Node or set `NODE_OPTIONS` / Dart `sass` yourself as for a stock Laravel Mix 2 project.
