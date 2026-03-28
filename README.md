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
