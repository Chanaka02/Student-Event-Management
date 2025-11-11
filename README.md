# Student Event Management — Minimal App

Minimal PHP + MySQL student event management app for classroom use.

Requirements
- PHP 7.4+ with PDO MySQL
- MySQL / MariaDB
- Apache or Nginx (document root -> `public/`) or use PHP built-in server for testing


Quick start for XAMPP (Windows)

1. Copy the project folder into XAMPP's htdocs directory, for example:

```powershell
Copy-Item -Recurse -Force . "C:\xampp\htdocs\student-event-app"
```


2. Create the database and import schema using phpMyAdmin or the MySQL CLI:

phpMyAdmin: open http://localhost/phpmyadmin, create database `student_events`, import `sql/schema.sql`.

MySQL CLI (PowerShell):

```powershell
mysql -u root -p < .\sql\schema.sql
```

3. Edit `src/db.php` if you need to change DB credentials (XAMPP default user is `root` with no password).

4. Start Apache from the XAMPP control panel and open:

	http://localhost/student-event-app/public/

Notes
- Assets are placed inside `public/assets/` so the `public/` folder can be used as the web root under XAMPP.
- The one-time setup script was removed; create an admin user manually via SQL or using the signup page and change their `role` to `admin` in the `users` table.

Optional: bundle the hero image locally (recommended)
- If the hero photo isn't loading from the external URL, download it and save as `public/assets/img/hero.jpg`.
- Example: place the file at `C:\xampp\htdocs\student-event-app\public\assets\img\hero.jpg` and refresh the page.

Automatic helper (PowerShell)
- From the project root you can download the hero file with the included helper (Windows):

```powershell
.\scripts\download-hero.ps1
```

This saves the image to `public/assets/img/hero.jpg`. Delete the script after use if desired.

Files
- `public/` — web-accessible PHP pages
- `src/` — backend helpers (PDO, auth, event actions)
- `assets/` — CSS and JS
- `sql/schema.sql` — DB schema and sample data

Notes
- This is intentionally minimal. Remove `public/setup.php` after use.
