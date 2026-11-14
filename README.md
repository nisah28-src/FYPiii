# Program Structure Management System

A web-based system developed to streamline the management, review, and approval of academic programme structures at the faculty level.

## System Preview 
 - A presentation outlining the project background, 
objectives, system architecture, key functionalities, 
and development approach.

[https://canva.link/40khzx9mfntdbzz]

## Project Overview

The **Program Structure Management System** is a final-year project developed to improve the existing programme structure management workflow.

Previously, programme structure information was managed through spreadsheet-based and manual approval by email processes. This system aims to centralise documentation, improve information accessibility, and facilitate structured review and approval workflows between faculty personnel.

## Objectives

- Centralise academic programme structure records.
- Streamline document submission and review processes.
- Facilitate communication between Heads of Programme (HOP), Heads of Department (HOD), and faculty staff.
- Reduce reliance on manual spreadsheet-based workflows.

## Key Features

- **User Management & Role-Based Access Control:** Different access permissions for administrators and faculty personnel.
- **Programme Structure Management:** Create, view, and update programme structure records.
- **Document Management:** Upload and manage relevant academic documents.
- **Review & Approval Workflow:** Enable HOD to review, comment, approve, or reject submitted structures.
- **Excel Import:** Import programme structure information from spreadsheet files.
- **PDF Generation:** Generate downloadable documents or reports.

## System Users

- User Role - Responsibilities
- HOP - Manage and submit programme structures
- HOD - Review, comment, approve, or reject submissions
- Staff - Access relevant programme information
- Admin - Manage users and system administration

## Technology Stack

- Category = Technology 
- Backend = PHP, Laravel 12 
- Frontend = Livewire, Tailwind CSS, DaisyUI
- Database = MySQL
- Development Environment = WAMP , Laravel Herd
- Version Control = Git, GitHub

## Installation & Setup

### Prerequisites

- PHP 8.4 or compatible version
- Composer
- Node.js and npm
- MySQL
- WAMP or another compatible local development environment

### 1. Clone the Repository

```bash
git clone https://github.com/nisah28-src/FYPiii.git
cd FYPiii
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Configure the database credentials in the `.env` file.

### 4. Database Setup

```bash
php artisan migrate
```

If database seeders are available, run:

```bash
php artisan db:seed
```

### 5. Build Frontend Assets

```bash
npm run build
```

### 6. Run the Application

```bash
php artisan serve
```

Access the application at:

http://127.0.0.1:8000


## Project Status

Developed as part of a Bachelor of Computer Science (Software Engineering) Final Year Project.

**Development Status:** Academic project / development prototype.

## Author

**Wan Anisah Solehah**

Bachelor of Computer Science (Software Engineering)

GitHub: [nisah28-src](https://github.com/nisah28-src)
