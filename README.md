# 🏫 School Management System

A full-featured School Management System built with **Laravel**, offering both a traditional **Blade admin panel** and a **versioned REST API** (`/api/v1`) for external clients (mobile apps, SPA frontends, third-party integrations).

The system supports three roles — **Admin**, **Teacher**, and **Student** — each with scoped access to students, classes, subjects, grades, attendance, and announcements.

---

## ✨ Features

### Core academic management
- 👥 **User & role management** — Admin / Teacher / Student roles via [Spatie Laravel-Permission](https://spatie.be/docs/laravel-permission)
- 🎓 **Students** — CRUD, search/filter, class assignment, guardian info
- 👨‍🏫 **Teachers** — CRUD, specialization, subject/class assignments
- 🏫 **Classes** — class + section management
- 📚 **Subjects & Class-Subject-Teacher assignments** — link teachers to subjects per class
- 📝 **Grades** — teachers submit marks per student/subject, with duplicate-entry prevention and subject-assignment validation
- 📅 **Attendance** — bulk attendance marking per class/date, with role-based create/update permissions (teachers create, admins update)
- 📢 **Announcements** — role-targeted announcements (all / admin / teacher / student) with automatic notifications

### Access control
- 🔐 Every resource is protected with **Laravel Policies** (`viewAny`, `view`, `create`, `update`, `delete`) — not just route middleware
- Role-scoped data: teachers only see their own classes/students; students only see their own records

### Reports & exports
- 📄 **PDF reports** (single student or full roster) via `barryvdh/laravel-dompdf`

### Notifications
- ✉️ Welcome email on student registration (**queued**, non-blocking)
- 🔔 In-app/database notifications for new grades, new attendance records, and announcements

### API
- 🔑 Token-based authentication via **Laravel Sanctum**
- 📦 Versioned under `/api/v1`
- 🧩 Consistent JSON responses using **API Resources** (`UserResource`, `StudentResource`, `GradeResource`, etc.)
- 🚦 Proper HTTP status codes (`201` created, `403` forbidden, `422` business-rule conflicts, etc.)

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Auth (web) | Laravel Breeze (session-based) |
| Auth (API) | Laravel Sanctum (token-based) |
| Authorization | Spatie Laravel-Permission + Laravel Policies |
| Frontend (admin panel) | Blade / Tailwind CSS / Vite |
| Database | MySQL |
| PDF generation | barryvdh/laravel-dompdf |

---

## 📋 Requirements

- PHP 8.1 – 8.4
- Composer
- Node.js & npm
- MySQL

---

## 🚀 Installation

```bash
# 1. Clone the repository
git clone https://github.com/ahmad-suliman/school_mangment_system.git
cd school_mangment_system

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Copy the environment file and generate the app key
cp .env.example .env
php artisan key:generate

# 5. Configure your database credentials in .env
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Build frontend assets
npm run dev

# 8. Start the local development server
php artisan serve
```

The Blade admin panel will be available at `http://127.0.0.1:8000`.
The API will be available at `http://127.0.0.1:8000/api/v1`.

### Queue worker (required for emails/notifications)

Emails (e.g. the welcome email) are queued rather than sent synchronously. Run a queue worker alongside the app:

```bash
php artisan queue:work
```

---

## 🔑 Authentication

### Web (Blade)
Standard Breeze session-based login at `/login`.

### API
Token-based via Sanctum:

```
POST /api/v1/login
Content-Type: application/json
Accept: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

Response:
```json
{
  "user": { "...": "..." },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

Use the token on subsequent requests:
```
Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxx
Accept: application/json
```

To log out (revokes only the token used in that request):
```
POST /api/v1/logout
```

> **Note:** Web logout (session) and API logout (token) are independent — logging out of the Blade panel does not revoke API tokens, and vice versa. This mirrors how most real-world apps separate browser sessions from API/mobile sessions.

---

## 📡 API Overview

All endpoints are prefixed with `/api/v1` and (except `/login`) require a valid Sanctum bearer token.

| Resource | Endpoints |
|---|---|
| Auth | `POST /login`, `POST /logout`, `GET /user` |
| Students | `GET/POST /students`, `GET/PUT/DELETE /students/{id}` |
| Teachers | `GET/POST /teachers`, `GET/PUT/DELETE /teachers/{id}` |
| Classes | `GET/POST /classes`, `GET/PUT/DELETE /classes/{id}` |
| Class-Subject-Teacher | `GET/POST /class-subject-teachers`, `PUT/DELETE /class-subject-teachers/{id}` |
| Grades | `GET/POST /grades`, `PUT/DELETE /grades/{id}` |
| Attendance | `GET/POST /attendance`, `PUT/DELETE /attendance/{id}`, `POST /attendance/load-students` |
| Announcements | `GET/POST /announcements`, `PUT/DELETE /announcements/{id}` |
| Profile | `GET/POST /profile`, `PUT /profile/password`, `DELETE /profile` |
| Dashboard | `GET /dashboard` *(role-scoped)* |
| Reports | `GET /reports/students/pdf`, `GET /reports/students/{id}/pdf` |

**TODO:** Update this table if any endpoint names/paths differ from your final `routes/api.php`.

---

## 🔐 Roles & Permissions

| Role | Access |
|---|---|
| **Admin** | Full access to all resources |
| **Teacher** | Manage grades/attendance for their assigned classes & subjects only; create attendance (cannot update it) |
| **Student** | Read-only access to their own grades, attendance, and profile |

Enforced via a combination of:
- Route middleware (`auth:sanctum`, `role:admin`, etc.)
- Laravel Policies for per-record checks (e.g. a teacher can only grade students in classes they're assigned to)

---

## 🔑 Default Demo Accounts

**TODO:** Fill in with real seeded accounts, e.g.:

| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | password |
| Teacher | teacher@example.com | password |
| Student | student@example.com | password |

---

## 📂 Project Structure

```
app/
  Http/
    Controllers/          # Blade (web) controllers
    Controllers/Api/V1/   # API controllers
    Requests/              # Form Request validation classes
    Resources/             # API Resource classes (JSON shaping)
  Models/
  Notifications/
  Policies/
database/
  migrations/
  seeders/
resources/
  views/                   # Blade templates
routes/
  web.php                  # Blade routes
  api.php                  # API routes (prefixed /v1)
  auth.php                 # Breeze auth routes
tests/
```



## 👤 Author

**Ahmad Suliman**
GitHub: [@ahmad-suliman](https://github.com/ahmad-suliman)
