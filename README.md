# student-management
a simple Student Management System built with PHP and MySQL. It allows you to add, view, edit, and delete student records. Designed for learning and basic CRUD operations using a relational database.
## 📦 Setup Instructions

To get started with this Student Management System project, follow these simple steps:

### 1. 📂 Import the Database

Import the `student_db.sql` file into your MySQL server:

- Open phpMyAdmin or your preferred MySQL client.
- Create a new database (or let the script do it).
- Import the provided `student_db.sql` file.

> This will create the required tables: `users` and `students`.

---

### 2. ⚙️ Run the Configuration File (Once Only)

Run the `config.php` file **only once** to insert a default admin user into the `users` table.

It will create a default user with the following credentials:

- **Username**: `admin`  
- **Password**: `1234` (you can change it later from the profile page)

✅ After running it once, you don't need to run this file again.

---

### 3. 🚀 Start Using the App

You can now log in using the default admin account and start managing student data.

- Add students
- View and edit student records
- Filter/search students
- Change your password

---

> ⚠️ For security, it's recommended to delete or disable `config.php` after the initial setup.
