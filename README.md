# Smart Parking System

This Smart Parking System is a web-based platform that allows users to register, book parking slots, and make payments online. It also provides an admin dashboard for managing users and viewing booking history.

## 🔧 Features

### 🧑‍💻 User Functions
- Register and log in as a user
- View available parking slots
- Book parking with selected duration
- Submit vehicle and card information
- View booking confirmation and transaction details
- Cancecllation for the booked parking

### 🛠️ Admin Functions
- Secure admin login with session validation
- View all registered user details (ID, Username, Email)
- View booking history (Date, Duration, Fee, Vehicle)
- Manage session-based access control
- Centralized admin dashboard interface

## 🗂️ Project Structure
- `htdocs/php/`: Contains all PHP logic files (login, register, admin dashboard, etc.)
- `htdocs/php/bookings.json`: Stores booking history in JSON format
- `htdocs/php/styles.css`: Common styles for the platform
- `index.html`: Main landing page
- `login.php`: User and admin login interface
- `register.php`: User registration form
- `admin_dashboard.php`: Admin-only dashboard for viewing users and booking history

## 💾 Technologies Used
- **Frontend**: HTML5, CSS3
- **Backend**: PHP
- **Database**: MySQL (InfinityFree hosting)
- **Session Handling**: PHP sessions for authentication and role-based access
- **Storage**: JSON for booking records (demo purposes)

## 🖥️ Hosting
The system is hosted on [InfinityFree](https://infinityfree.net/), using free hosting services with remote MySQL support.

## 🚀 Setup Instructions

1. Upload all files to your InfinityFree `htdocs` directory.
2. Import your MySQL database using phpMyAdmin.
3. Update your database credentials in PHP files if needed.
4. Ensure the `bookings.json` file exists and has correct read/write permissions.
5. Access the site via your domain (e.g., `ebookingcarpark.ct.ws`).

## 🔐 Admin Login
The admin login is restricted via session and role-based validation.
Admins can:
- View all user accounts
- See all booking logs stored in the JSON file

## 📌 Notes
- Myparking-main will be the latest version of code
- Version 1 and 2 use store under 'Tags'
- Booking history is stored in a JSON file for simplicity.
- MySQL is used to store user account information.
- Admin dashboard layout is split into two sections:
  - Top: Registered users (fetched from MySQL)
  - Bottom: Booking history (fetched from JSON)

## 📄 License
This project is created for educational/demo purposes and does not include real payment processing. Use responsibly and customize as needed.

---
