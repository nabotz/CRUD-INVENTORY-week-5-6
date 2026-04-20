# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

PHP + MySQL inventory management app (Sistem Manajemen Inventori) with session auth, CRUD for Kategori/Produk/Supplier/Riwayat Stok/User, file uploads, FPDF report printing, and a Chart.js dashboard. UI text and variable names are Indonesian.

Stack: procedural PHP (no framework), PDO for MySQL, vanilla HTML/CSS, Chart.js (vendored at `js/chart.js`), FPDF (vendored at `riwayat_stok/fpdf186/`). Targets XAMPP/WAMP.

## Running locally

No build step. Serve the project root through Apache (XAMPP/WAMP `htdocs`) or `php -S localhost:8000` from the project root.

Database setup:
- Create DB `inventori_db` and import `inventori_db.sql` (schema + seed data).
- If upgrading an older DB, also run `migrate_remember_token.sql` to add the remember-me column.
- DB credentials are hardcoded in `koneksi.php` (host=localhost, user=root, pass=empty). Change there if needed — no env config.
- Seeded users exist in the SQL dump but with unknown plaintext passwords; register a new user via `register.php` to get a working login.

There are no tests, linters, or package manager (no `composer.json`, no `package.json`).

## Architecture

### Request flow
Every page is an independent PHP file — no router, no front controller. Navigation is via `<a href>` to specific `.php` files. The resource sidebar lives in `menu.php` (copied/linked from child pages through `includes/sidebar.php` where used).

### Auth boundary
`auth.php` is the guard — it calls `session_start()`, includes `includes/csrf.php`, and redirects to `index.php` if no `$_SESSION['user_id']`. It also handles remember-me auto-login by reading `remember_token` / `remember_user` cookies, hashing the token with SHA-256, and matching against `users.remember_token`.

**Rule:** every protected page must start with `require_once 'auth.php';` (or the correct relative path, e.g. `../auth.php` from subdirectories) **before** `include 'koneksi.php'`. Pages missing this guard leak data. See `menu.php:2`, `api_cek_produk.php:2`, `kategori/SimpanKategori.php:2` for the pattern. Login/register/logout pages call `session_start()` and `include_once 'includes/csrf.php'` directly instead.

### CSRF protection
`includes/csrf.php` provides two functions: `csrf_token()` generates/returns a session-stored 64-char hex token; `csrf_check()` validates `$_POST['csrf_token']` against it with `hash_equals`, dying 403 on mismatch. **Session must already be started before including this file.** All POST handlers must call `csrf_check()` at the top. Forms must embed `<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"`.

### Database access
`koneksi.php` opens a single `$koneksi` PDO handle with `ERRMODE_EXCEPTION`, `FETCH_ASSOC`, and `EMULATE_PREPARES=false`. All pages `include` it and use `$koneksi->prepare(...)->execute([...])` with positional placeholders. **Exception:** `riwayat_stok/CetakRiwayatStokPdf.php` builds SQL via string interpolation of `$_GET` values — this is a SQLi hole; any edits there should convert to prepared statements.

### CRUD convention
Each domain has its own directory (`kategori/`, `produk/`, `supplier/`, `riwayat_stok/`, `user/`) following a consistent file naming pattern:
- `Tampil{Entity}.php` — list/index view
- `Tambah{Entity}.php` — add form
- `Simpan{Entity}.php` — insert handler (POST target of Tambah form)
- `Koreksi{Entity}.php` — edit form (loads record by id via GET)
- `SimpanKoreksi{Entity}.php` — update handler
- `Hapus{Entity}.php` — delete handler (GET)

Handlers generally `header('Location: Tampil{Entity}.php')` after success. Input sanitization uses a local `bersih()` helper that wraps `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')` — it's redefined per file rather than shared.

### File uploads
Photos go to per-domain `uploads/` subfolders: `kategori/uploads/` and `user/uploads/`. New files are renamed to `uniqid("foto_") . "." . $ext` and validated against `['jpg','jpeg','png','gif']`. Folders are auto-created with `mkdir(..., 0777, true)` if missing. Stored filename goes into the DB `foto` column.

### Session shape
After login: `$_SESSION['user_id']`, `['username']`, `['nama']`, `['foto']`. Used throughout the sidebar to render the avatar (`user/uploads/<foto>`).

### Dashboard
`menu.php` is the dashboard: runs several aggregate queries (stok masuk hari ini, total transaksi/produk/supplier, kategori breakdown, 12-month stock value trend, 5 latest transactions) and feeds `js/chart.js` with server-rendered JSON arrays.

### PDF export
`riwayat_stok/CetakRiwayatStokPdf.php` uses FPDF (vendored) to render a landscape A4 report filtered by `?bulan=&tahun=`. Output is streamed directly — don't add HTML before it.

### Public JSON API
`api_cek_produk.php` returns `{ success, produk[] }` with per-product stock summary. It IS auth-guarded.

## Schema quick reference

Tables in `inventori_db`: `kategori`, `produk` (FK → kategori), `supplier`, `transaksi_stok` (FK → supplier, produk), `users` (with `remember_token` from the migration). Stock level is computed on the fly as `SUM(transaksi_stok.jumlah)` — there is no denormalized stock column.
