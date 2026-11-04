# Student Registration & Academic Portal (Super Admin & Fee Permission System)

Note:   if need its Data Base contact me I will provide it and its for the evets registration 

A dedicated, standalone Laravel application for student registration, convocation fee challan vouchers, and **Super Admin Fee Permission & Verification Control**.

---

## Project Details

- **Directory:** `D:\laravel\STUDENT_REGISTRATION`
- **Database Engine:** PostgreSQL (pgAdmin)
- **Database Name:** `student_registration_db`
- **Port:** `8001`
- **Framework:** Laravel 12 with Laravel Sanctum

---

## Super Admin Access & Credentials

- **Admin Login URL:** [http://127.0.0.1:8001/login](http://127.0.0.1:8001/login)
- **Super Admin Email:** `admin@example.com`
- **Super Admin Password:** `admin123`
- **Role:** `admin` (Has Super Admin Rights)

---

## Core Security & Permission Rules

1. **Student Boundary:**
   - When a student registers or saves their profile, they **only see the Invoice Report / Fee Challan**.
   - After paying (at the bank or online transfer/app), the student can **attach/upload their paid voucher or transaction screenshot**.
   - The student **CANNOT modify or update their fee status to `PAID`**.
   - Upon upload, the student status becomes **`pending_verification`**.

2. **Super Admin Super Rights:**
   - Only the **Super Admin** can update fee statuses and fee structures.
   - Super Admin can view all registered students and their uploaded voucher images or PDF receipts.
   - **1-Click Approve:** Super Admin marks the payment as **`PAID`**, recording the verifier ID, timestamp, and amount.
   - **Reject Proof:** Super Admin can reject illegible or incorrect vouchers with a reason (e.g. "Stamp missing", "Amount mismatch"), which sets the status back to **`UNPAID`** and prompts the student to re-attach.
   - **Permission & Fee Structure Override Form:** Super Admin can manually override any student's fee amount (grant waivers/discounts), guest count, due date, and admin internal notes.

---

## Fee Structure Rules

- **Student Alone (0 Guests):** `PKR 15,000`
- **Student + 1 Guest:** `PKR 20,000` (`15,000` base + `5,000` guest fee)
- **Student + 2 Guests:** `PKR 25,000` (`15,000` base + `10,000` for 2 guests)
- *Note:* Super Admin can override this amount in the Admin Permission Form.

---

## Web Portal URLs

### Student URLs
- **Student Registration:** [http://127.0.0.1:8001/register](http://127.0.0.1:8001/register)
- **Student Login:** [http://127.0.0.1:8001/login](http://127.0.0.1:8001/login)
- **My Profile & Registration:** [http://127.0.0.1:8001/student/details](http://127.0.0.1:8001/student/details)
- **Printable Bank Challan (Invoice Report):** [http://127.0.0.1:8001/student/challan](http://127.0.0.1:8001/student/challan)
- **Fee Payment & Attach Proof:** [http://127.0.0.1:8001/student/payment](http://127.0.0.1:8001/student/payment)

### Super Admin URLs (Protected by `admin` middleware)
- **Admin Dashboard:** [http://127.0.0.1:8001/admin/dashboard](http://127.0.0.1:8001/admin/dashboard)
- **Verification Queue:** [http://127.0.0.1:8001/admin/students?status=pending_verification](http://127.0.0.1:8001/admin/students?status=pending_verification)
- **All Students List:** [http://127.0.0.1:8001/admin/students](http://127.0.0.1:8001/admin/students)
- **Student Permission & Fee Override Form:** [http://127.0.0.1:8001/admin/students/{id}](http://127.0.0.1:8001/admin/students/1)

---

## RESTful API Endpoints

### Student APIs
| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `POST` | `/api/register` | Register new student (auto-generates Challan No & Fee) | No |
| `POST` | `/api/login` | Login & generate Sanctum token | No |
| `GET` | `/api/student/me` | Authenticated student profile | `auth:sanctum` |
| `POST` | `/api/student/update` | Update registration profile | `auth:sanctum` |
| `GET` | `/api/student/challan` | Get challan & fee breakdown | `auth:sanctum` |
| `POST` | `/api/student/upload-receipt` | Attach paid voucher/screenshot proof | `auth:sanctum` |

### Super Admin APIs (`auth:sanctum` + `admin` middleware)
| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/admin/stats` | Dashboard statistics (total students, pending, paid, revenue) |
| `GET` | `/api/admin/students` | Filterable & searchable list of student registrations |
| `GET` | `/api/admin/students/{id}` | Single student profile, uploaded slip & verification logs |
| `POST` | `/api/admin/students/{id}/approve` | Approve payment proof & mark status as `paid` |
| `POST` | `/api/admin/students/{id}/reject` | Reject payment proof with reason & set status to `unpaid` |
| `POST` | `/api/admin/students/{id}/update-fee` | Override fee amount, guest count, due date & permissions |
