<p align="center">
<img src="/public/images/librio-small.png"/>
</p>

# Librio Legacy

Open-source library app for small libraries. This codebase is the original idea and is **deprecated**.

## Requirements

- PHP 8+, Composer, database, web server (see `composer.json` for PHP extensions).
- **Node** 18–22 and **npm 8.3+** for builds. **`nvm use`** (or install) respects **`.nvmrc`** → Node **20** suggested.

## Stack (short)

| Layer | Notes |
|--------|--------|
| **Backend** | PHP 8+, Laravel 9 — see `composer.json` for packages (Laratrust, Collective, Excel, …). |
| **UI (CSS)** | AdminLTE 2 + **Bootstrap 3** CSS, Font Awesome 4, Select2, iCheck, custom `skin-librio`. |
| **JS** | jQuery 3, **Bootstrap 4** JS (differs from BS3 CSS), AdminLTE, Select2, Chart.js / Chartisan, Axios. |
| **Assets** | Laravel Mix 2 / webpack 3: `npm install`, then `npm run development` or `npm run production`. |

`package.json` already sets **`NODE_OPTIONS=--openssl-legacy-provider`** for webpack on modern Node, and **`overrides`** + **`sass`** replace broken **`node-sass`** for current Node. After pulling dependency changes, run **`npm install`** again.
