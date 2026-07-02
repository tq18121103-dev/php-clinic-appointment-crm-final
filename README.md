# Clinic Appointment CRM - PHP MVC Final Project

## Overview

Clinic Appointment CRM is a secure PHP MVC web application designed for clinic receptionists and admins to manage patients and clinical appointments.  
The project focuses on secure form handling, session login, PDO database access, CRUD operations, search, pagination, sorting, anti-spam mechanisms, and robust error handling.

## Tech Stack

- **Core:** PHP (pure MVC pattern)
- **Database:** MySQL (via PDO with prepared statements)
- **Dependency Management:** Composer PSR-4 Autoload
- **Security Features:** CSRF Protection, Honeypot, Session Rate Limiter, Session Regenerate ID, Secure Cookie Flags, Session Timeout.

## Folder Structure

```text
app/
  Controllers/          # Request controllers
  Core/                 # Database connection, Router, Exceptions and global Helpers
  Repositories/         # Database access layer (SQL queries using Prepared Statements)
  Services/             # Business logic and form validations
  Views/                # Presentation templates (layouts, errors, partials)
config/                 # Database and Application configurations
database/               # SQL database schema and seeds
public/                 # Web server root, assets and Front Controller index.php
storage/logs/           # Production log file directory
docs/                   # Performance analysis documentation
README.md               # Project documentation
```

## Database Setup

1. **Database Name:** `clinic_appointment_crm`
2. **Import Database Schema:**
   ```bash
   mysql -u root -p < database/schema.sql
   ```
3. **Import Database Seed Data:**
   ```bash
   mysql -u root -p < database/seed.sql
   ```

## Running the Project

Run the PHP built-in web server pointing to the `public/` directory:
```bash
php -S localhost:8000 -t public
```

Access the application in your browser:
[http://localhost:8000](http://localhost:8000)

## Demo Accounts

- **Admin Account (Full Access):**
  - **Username:** `admin`
  - **Password:** `123456`
- **Staff Account:**
  - **Username:** `staff1`
  - **Password:** `123456`

## Application Routes

| Method | Path | Controller@Action | Auth Required | Description |
| :--- | :--- | :--- | :--- | :--- |
| **GET** | `/` | `HomeController@index` | No | Home redirect (to dashboard or login) |
| **GET** | `/login` | `AuthController@login` | No | View login page |
| **POST**| `/login` | `AuthController@handleLogin` | No | Handle session login with regenerate ID |
| **POST**| `/logout` | `AuthController@logout` | Yes | Secure logout and clear cookies |
| **GET** | `/dashboard` | `DashboardController@index` | Yes | General admin panel dashboard |
| **GET** | `/health` | `HealthController@index` | No | API endpoint checking DB status |
| **GET** | `/public-patients/create` | `PublicPatientController@create` | No | Public patient registration page |
| **POST**| `/public-patients` | `PublicPatientController@store` | No | Public submit with Honeypot & Rate Limit |
| **GET** | `/patients` | `PatientController@index` | Yes (Admin) | List patients with search/paging/sorting |
| **GET** | `/patients/create` | `PatientController@create` | Yes (Admin) | View patient creation form |
| **POST**| `/patients` | `PatientController@store` | Yes (Admin) | Store new patient data |
| **GET** | `/patients/edit` | `PatientController@edit` | Yes (Admin) | View patient edit form |
| **POST**| `/patients/update` | `PatientController@update` | Yes (Admin) | Update patient data |
| **POST**| `/patients/delete` | `PatientController@delete` | Yes (Admin) | Delete patient record |
| **GET** | `/appointments` | `AppointmentController@index` | Yes | List appointments with patient join |
| **GET** | `/appointments/create` | `AppointmentController@create` | Yes (Admin) | View appointment creation form |
| **POST**| `/appointments` | `AppointmentController@store` | Yes (Admin) | Store new appointment |
| **GET** | `/appointments/edit` | `AppointmentController@edit` | Yes (Admin) | View appointment edit form |
| **POST**| `/appointments/update` | `AppointmentController@update` | Yes (Admin) | Update appointment |
| **POST**| `/appointments/delete` | `AppointmentController@delete` | Yes (Admin) | Delete appointment |

---

## Test Cases for Lab06 Requirements

1. **Security & Session CSRF Check:**
   - Attempt to submit any creation form by deleting the `_csrf_token` input element. 
   - *Expected:* System rejects the request immediately with a `403 Forbidden` or `Invalid CSRF token`.
2. **Anti-spam Honeypot Check:**
   - Navigate to `/public-patients/create`, inspect and fill the hidden `website_url` input field, then submit.
   - *Expected:* HTTP response code `400 Bad Request` with message `Spam detected (Honeypot)`.
3. **Anti-spam Session Rate Limit Check:**
   - Submit the public registration form successfully. Click Back and submit again within 10 seconds.
   - *Expected:* System blocks submission and displays: "Bạn đang gửi yêu cầu quá nhanh. Vui lòng đợi X giây nữa."
4. **Method Not Allowed Check (405):**
   - Access `GET /login` using the `POST` method (or a POST-only route like `/logout` with `GET`).
   - *Expected:* System returns a custom `405 Method Not Allowed` error page.
5. **Production Error Masking (500):**
   - Change `debug` key to `false` in `config/app.php`. Introduce a database connection error in `config/database.php`.
   - *Expected:* System renders the clean `errors/500` page without displaying database passwords, SQL statements, or stack traces. The error trace is safely stored in `storage/logs/error.log`.
