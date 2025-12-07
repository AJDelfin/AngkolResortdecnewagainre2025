# Project Blueprint: Angkol Resort Hub

## 1. Overview

This document outlines the development plan for the Angkol Resort Hub, a comprehensive web application for managing resort operations. The application will provide a centralized platform for staff to manage reservations, guest information, billing, and financial reporting. It will also offer a user-friendly interface for guests to book accommodations and services.

## 2. Style and Design

### 2.1. Aesthetics

The application will feature a modern and visually appealing design that is both professional and easy to use. The user interface will be clean, with a balanced layout and ample white space to improve readability. The color palette will be inspired by the natural beauty of a tropical resort, with a focus on calming and inviting colors.

### 2.2. Color Palette

*   **Primary:** `#15803d` (dark green)
*   **Cream:** `#fdfbf6`
*   **Dark:** `#1a1a1a`

### 2.3. Typography

*   **Headlines:** "Playfair Display", serif
*   **Body Text:** "Lato", sans-serif

## 3. Implemented Features

*   **User Roles:** The application will have distinct roles for administrators, staff, and customers, each with a tailored dashboard and specific permissions.
*   **Admin Dashboard:** A comprehensive dashboard for administrators to manage all aspects of the resort, including user accounts, content, and system settings.
*   **Financial Reports:** A dedicated section for viewing and managing financial reports, providing insights into revenue, expenses, and profitability.
*   **Export Financial Reports:** Functionality to export financial reports to a CSV file.
*   **Food Packages Management:** A dedicated section for managing food packages, including creating, editing, and deleting packages, as well as bulk deletion.

## 4. Current Task: Add Bulk-Destroy to Food Packages Module

### 4.1. Goal

The current development focus is on adding bulk-destroy functionality to the food packages module, allowing administrators to delete multiple food packages at once.

### 4.2. Plan

1.  **Add Route:** Add a `delete` route to `routes/web.php` for bulk deletion of food packages.
2.  **Add Controller Method:** Add a `bulkDestroy` method to the `FoodPackageController` to handle the logic for deleting multiple food packages.
3.  **Update Index View:** The `index.blade.php` file for food packages was previously updated to include a form and checkboxes for bulk deletion.
4.  **Update `index` Method:** The `index` method in the `FoodPackageController` was updated to use pagination.
