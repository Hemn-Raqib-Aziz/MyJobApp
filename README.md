## MyJobApp (Laravel) – Full-Stack Job Platform

A fully featured job marketplace built with Laravel, designed to provide a complete hiring workflow for both job seekers and employers. The application focuses on clean architecture, scalability, and real-world backend logic.

### Overview

MyJobApp enables two types of users—job seekers and job posters—to interact through a structured platform. It handles everything from authentication and profile setup to job posting, applications, and automated email communication.

### Core Features

#### Authentication & User Flow

* Secure registration and login system
* Email verification before accessing the platform
* Mandatory profile setup after registration based on user role

#### Role-Based Profiles

* **Job Seekers**:

  * Profile title, age, gender, location, bio

* **Job Posters**:

  * Industry, location, company description, external URL

* Full profile management (create, update, delete) for both roles

#### Job Management (Job Posters)

* Create, edit, and delete job posts
* View and manage applications per job
* Access applicant profiles directly
* Receive email notifications when a new application is submitted

#### Job Applications (Job Seekers)

* Browse and search for available jobs
* Apply with CV and cover letter
* Track application status updates
* Receive email notifications when application status changes

#### Notification System

* Email alerts for:

  * New job applications (to job posters)
  * Application status updates (to job seekers)
  * Newly posted jobs (subscription-based)
* Users can unsubscribe from job notification emails

### Technical Highlights

* Built with **Laravel** using MVC architecture
* Relational database design with MySQL
* Clean separation of concerns and scalable structure
* Email handling integrated for real-time communication
* Role-based authorization and middleware protection

### Purpose

This project demonstrates the implementation of a real-world system with complex user flows, relational data handling, and event-driven communication. It highlights backend design decisions, maintainability, and practical full-stack development skills.













# Installation & Setup Instructions

Follow these steps to get MyJobApp running locally:

## 1. Clone the Repository

```
git clone https://github.com/Hemn-Raqib-Aziz/MyJobApp.git
cd MyJobApp
```

## 2. Install PHP Dependencies

Make sure you have PHP and Composer installed. Then run:

```
composer install
```

This will install all Laravel dependencies required for the project.

## 3. Install Node.js Dependencies (Frontend)

Ensure Node.js (version 20.19+ recommended) and npm are installed:

```
npm install
```

## 4. Create Your `.env` File

Copy the `.env.example` file to `.env`:

```
cp .env.example .env
```

Update `.env` with your environment settings. Example for database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myjobapp
DB_USERNAME=root
DB_PASSWORD=
```

## 5. Set Application Key

Generate the Laravel app key:

```
php artisan key:generate
```

## 6. Database Setup

Make sure your MySQL server is running and you have created the database. Then run migrations:

```
php artisan migrate
```

## 7. Configure Email Sending

To enable email notifications for applications and job postings, update your `.env` with your SMTP credentials. Example using Gmail:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your_email_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noReply@gmail.com"
MAIL_FROM_NAME="MyJobApp"
```

> **Important:** Use your own credentials in production. Gmail may require an App Password or enabling "Less Secure Apps" for testing.

## 8. Start the Application

You can start Laravel and Vite together:

```
composer run dev
```

- Laravel backend will run at http://127.0.0.1:8000
- Frontend assets will be served by Vite
- Queue listener will handle job application emails in real-time

## 9. Clear Cache & Views (Optional)

If you face caching issues:

```
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 10. Access the Application

Open http://127.0.0.1:8000 in your browser. Register as a Job Seeker or Job Poster, complete the profile, and test the job posting/application workflow. Email notifications should work if SMTP is properly configured.
