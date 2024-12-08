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
```

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
2. Open your browser and navigate to `http://localhost/voting_system/public/index.php`.
3. You should see the homepage where you can log in or register as an employee.
4. Once logged in, employees can vote for their peers in various categories and view the results.
   

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

---

## HTTP Requests and API Endpoints

### 1. **POST /login**
   - **URL**: `/login.php`
   - **Method**: `POST`
   - **Parameters**:
     - `email`: The email address of the employee.
     - `password`: The password for authentication.
   - **Response**: 
     - On successful login, the user is redirected to `index.php`.
     - On failure, an error message is displayed.

   #### Example Request:
   ```http
   POST /login.php
   Content-Type: application/x-www-form-urlencoded
   Body: 
     email=user@example.com
     password=securepassword
   ```

   #### Example Response:
   ```html
   <p>Invalid email or password.</p>
   ```

### 2. **POST /register**
   - **URL**: `/register.php`
   - **Method**: `POST`
   - **Parameters**:
     - `name`: Full name of the employee.
     - `email`: The email address for account creation.
     - `password`: The password for the employee’s account.
   - **Response**: 
     - On successful registration, a success message is displayed.
     - If registration fails, an error message is shown.

   #### Example Request:
   ```http
   POST /register.php
   Content-Type: application/x-www-form-urlencoded
   Body: 
     name=John Doe
     email=john.doe@example.com
     password=securepassword
   ```

   #### Example Response:
   ```html
   <p>Registration successful!</p>
   ```

### 3. **POST /submit_vote**
   - **URL**: `/submit_vote.php`
   - **Method**: `POST`
   - **Parameters**:
     - `category`: The category the vote is for (e.g., "Team Player").
     - `nominee`: The employee being voted for.
     - `comment`: A comment accompanying the vote.
   - **Response**:
     - Upon successful vote submission, the user is redirected to the vote page with a success message.
     - If an error occurs, an error message is displayed.

   #### Example Request:
   ```http
   POST /submit_vote.php
   Content-Type: application/x-www-form-urlencoded
   Body: 
     category=Team Player
     nominee=2
     comment=John is always there to help the team!
   ```

   #### Example Response:
   ```html
   <p>Your vote has been submitted successfully!</p>
   ```

### 4. **GET /results**
   - **URL**: `/results.php`
   - **Method**: `GET`
   - **Parameters**: None.
   - **Response**: 
     - Displays a table of the voting results, including vote counts for each nominee per category, and the most active voters.

   #### Example Request:
   ```http
   GET /results.php
   ```

   #### Example Response:
   ```html
   <h1>Voting Results</h1>
   <table>
     <tr><th>Nominee</th><th>Votes</th></tr>
     <tr><td>John Doe</td><td>5 votes</td></tr>
   </table>
   ```

---

## Future Improvements

While I didn't use AJAX and JavaScript in this project due to my limited experience with them, I am eager to explore and implement these technologies in future projects. I believe integrating AJAX could have greatly enhanced the user experience by making the application more dynamic, allowing for better voting updates without page reloads. Additionally, incorporating JavaScript could have improved the client-side interaction and realtime feedback for users.

I am very interested in expanding my knowledge of these technologies and am excited about the opportunity to implement them in future projects. I am ready to learn and work with JavaScript, jQuery, and AJAX, as I understand their importance in creating better and more responsive web applications.
