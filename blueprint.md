# Project Blueprint

## Overview

This project is a full-stack web application built with Laravel. It is designed to be a reservation system with role-based access control for admins, staff, and customers.

## Implemented Features

### Style and Design
- Modern user interface with a clean and intuitive layout.
- Responsive design for both mobile and web.
- Consistent color scheme and typography.
- Use of icons to enhance user experience.

### User Roles and Permissions
- **Admin:** Full access to all system features, including user management (staff and customers) and all reservation data.
- **Staff:** Can view and manage reservations.
- **Customer:** Can make and view their own reservations.

### Authentication
- Separate login for customers.
- Combined login for admin and staff.
- Registration page for new customers.

## Current Task: Fix Login and Registration

### Plan
1.  **Create combined login for admin and staff:**
    *   Create a new controller `AdminLoginController` to handle authentication for both admin and staff.
    *   Create a new view `admin_login.blade.php` for the combined login form.
    *   Define a new route for the admin/staff login page.
2.  **Update user seeder:**
    *   Modify the `AdminUserSeeder` to use the passwords you provided for the admin and staff accounts.
3.  **Create a dedicated customer registration and login:**
    *   Ensure the default Laravel registration and login routes are used for customers.
4.  **Update navigation:**
    *   Modify the main welcome page to include links to the customer login/registration and the admin/staff login.
5.  **Run migrations and seeders:**
    *   Run the database migrations to create the necessary tables.
    *   Run the seeders to populate the database with the admin and staff users.
