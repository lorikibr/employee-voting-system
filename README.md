# Employee Voting System

This is a **PHP-based Employee Voting System** that allows employees to vote for their peers in different categories and track the votes. The system is built using **PHP (OOP)** and **MySQL**, and uses **XAMPP (Apache and MySQL)** for local development.

## Features

- Employees can vote in categories such as:
  - Makes Work Fun
  - Team Player
  - Culture Champion
  - Difference Maker
- Each vote includes a **mandatory comment**.
- Vote tracking stores the **voter**, **nominee**, **category**, **comment**, and **timestamp**.

## Prerequisites

Before starting the project, ensure you have the following installed:

- **XAMPP** (includes Apache and MySQL)
- **PHP** (version 7.4 or higher)
- **MySQL** for database management

## Installation and Setup

### 1. Clone the Repository

First, clone the repository to your local machine:

```bash
git clone https://github.com/lorikibr/employee-voting-system.git


### 2. Set Up XAMPP

1. Download and install [XAMPP](https://www.apachefriends.org/index.html).
2. Open **XAMPP Control Panel** and start **Apache** and **MySQL**.

### 3. Set Up the Database

1. Open **phpMyAdmin** from the XAMPP control panel (click **Admin** next to MySQL).
2. Create a new database named `voting_system`.
3. Create the following tables in your database using the provided SQL schema:

```sql
-- Table structure for table `categories`
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Table structure for table `employees`
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

-- Table structure for table `votes`
CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `nominee_id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
  FOREIGN KEY (`nominee_id`) REFERENCES `employees`(`id`),
  FOREIGN KEY (`voter_id`) REFERENCES `employees`(`id`)
);

-- Table structure for table `vote_counts`
CREATE TABLE `vote_counts` (
  `employee_id` int(11) NOT NULL,
  `vote_count` int(11) DEFAULT 0,
  PRIMARY KEY (`employee_id`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`)
);
```

### 4. Access the Application

1. Place the project files into the **htdocs** directory in your XAMPP installation (`C:\xampp\htdocs\`).
2. Open your browser and navigate to `http://localhost/employee-voting-system/`.
3. You should see the homepage where you can log in or register as an employee.
4. Once logged in, employees can vote for their peers in various categories and view the results.

Here’s the project structure in the format you requested:

## Project Structure

- `includes/Employee.php`: Class to manage employee data and operations.
- `includes/Vote.php`: Class to handle vote submissions and logic.
- `includes/db.php`: Database connection and management.
- `includes/Category.php`: Class to manage voting categories.

- `public/css/style.css`: Stylesheets for the project.
- `public/js/script.js`: JavaScript file.
- `public/index.php`: Main entry point for the application as a homepage.
- `public/login.php`: Login page for employee authentication.
- `public/register.php`: Registration page for new employees.
- `public/vote.php`: Page where employees can cast their votes.
- `public/submit-vote.php`: Handles the backend logic for submitting votes.
- `public/logout.php`: Log out functionality for employees.
- `public/results.php`: Displays the results of the voting process.

- `templates/header.php`: Reusable header template for the pages.


## Troubleshooting

- **Apache or MySQL not starting**: Ensure that no other processes are using ports 80 (Apache) or 3306 (MySQL). You can change the ports in the XAMPP control panel if needed.
