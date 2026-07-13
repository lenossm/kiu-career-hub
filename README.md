# KIU Career Hub

**Live site:** https://kiu-career-hub.onrender.com

Laravel app I built for my uni course. It’s a small career portal for Kutaisi International University where students, professors/TAs and the career office each get their own side of the system.

> Note: free Render hosting sleeps when nobody uses it. First open can take around 30–60 seconds.

---

## What you can do

**Students**
- make a profile (skills, bio, photo, links)
- browse all student vacancies
- see a match % based on skills (it’s just sorting help, nothing is hidden)
- apply with cover letter + resume

**Professors / TAs**
- faculty profile
- only see internal KIU positions (not student jobs)
- apply the same way

**Career office (admin)**
- post vacancies for students or for faculty
- check student + faculty applications
- manage office tasks

---

## Stack

- Laravel 13 / PHP 8.3
- SQLite
- Blade + Bootstrap 5 + my CSS
- session auth + role middleware
- file uploads for photos and resumes
- REST API under `/api/v1`

---

## Run locally

Need PHP 8.3+ and Composer.

```bash
git clone https://github.com/lenossm/kiu-career-hub.git
cd kiu-career-hub

composer install
cp .env.example .env
php artisan key:generate

# windows powershell:
New-Item -ItemType File -Force database/database.sqlite

# or on mac/linux:
# touch database/database.sqlite

php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Then open http://127.0.0.1:8000

### Seeded logins

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@kiu.test | password |
| Student | student@kiu.test | password |
| Professor | professor@kiu.test | password |

On the login page there are also quick buttons for these accounts (can turn off with `DEMO_LOGINS_ENABLED=false`).

---

## Useful env options

```
DEMO_LOGINS_ENABLED=true
ALLOW_ADMIN_REGISTER=false
```

I keep admin registration off on the public demo so random people can’t create admin accounts.

---

## Deploy

This one is live on Render (Docker):

https://kiu-career-hub.onrender.com

If you want to deploy your own copy: connect the repo as a Web Service, runtime Docker, set `APP_URL` to your Render URL.

There’s also a `Dockerfile` / `railway.toml` if you prefer Railway.

---

## Course stuff included

- MVC, migrations, Eloquent (1:N and M:N)
- CRUD + Form Requests + CSRF
- auth + middleware
- file uploads
- Blade layouts / components
- API with JsonResource

---

## Folder layout

```
app/Http/Controllers
app/Http/Middleware
app/Models
app/Services/VacancyMatchService.php
resources/views
routes/web.php
routes/api.php
public/css/app.css
```

---

## Me

**lenossm**  
GitHub: https://github.com/lenossm  
Project: https://github.com/lenossm/kiu-career-hub
