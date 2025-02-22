# Student Registration System

## Overview
The **Student Registration System** is a web-based application built with Laravel that allows students to register, enroll in courses, and manage payments. Teachers can manage courses, and administrators oversee user roles and financial transactions.

## Features
- **Student Features:**
  - User registration and authentication
  - Course browsing and enrollment
  - Payment processing using Stripe
- **Teacher Features:**
  - Course management
  - Viewing enrolled students
  - Assigning assessments
- **Admin Features:**
  - User management (students, teachers, admins)
  - Course creation and deletion
  - Payment and revenue tracking

## Tech Stack
- **Backend:** Laravel (PHP)
- **Frontend:** Blade (HTML, Tailwind CSS, JavaScript)
- **Database:** SQLite
- **Payments:** Stripe API
- **Testing:** PestPHP

## Installation
1. **Clone the Repository**
   ```sh
   git clone https://github.com/kua-University/student-registration-system_filimon.git
   cd student-registration-system_filimon
   ```

2. **Install Dependencies**
   ```sh
   composer install
   npm install && npm run dev
   ```

3. **Set Up Environment Variables**
   - Copy `.env.example` to `.env`
   ```sh
   cp .env.example .env
   ```
   - Update Stripe API keys in `.env`

4. **Generate Application Key**
   ```sh
   php artisan key:generate
   ```

5. **Run Migrations and Seeders**
   ```sh
   php artisan migrate --seed
   ```

6. **Start the Server**
   ```sh
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`

## Testing
Run tests using Pest:
```sh
php artisan test
```

---
**Author:** Filimon Haftom
**GitHub:** [phila-hh](https://github.com/phila-hh)


