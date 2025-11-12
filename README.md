# IT Desk - Ticket Support System

## 🚀 Overview
- Modern PHP, MVC Based Ticket Support System for efficient management of IT Support Tickets.
- Clean and Minimal UI using Bootstrap.
- Session based authentication
- JS based DataTable for searching, ordering and pagination of the rendered PHP Output.

## ✨ Features
- **User Authentication**: Secure login and registration for users and agents.
- **Ticket Management**: Create, view, and manage tickets with detailed status tracking.
- **Email Notifications**: Automated email notifications for ticket updates.
- **Role-Based Access Control (RBAC)**: Different access levels for users, agents, and admins.
- **Dashboard**: Customizable dashboards for users, agents, and admins to monitor ticket statistics.
- **Error Handling**: Centralized error handling and logging for better debugging.

## 🛠️ Tech Stack
- **Front-End**: HTML, CSS, Bootstrap, JQuery
- **Programming Language**: PHP
- **Frameworks and Libraries**:
  - [AltoRouter](https://github.com/altorouter/altorouter)
  - [PHPMailer](https://github.com/PHPMailer/PHPMailer)
  - DataTables - JS Library
- **Database**: MySQL
- **Version Control**: Git

## 📦 Installation

### Prerequisites
- Bootstrap 5.3 or later
- PHP 8.4.7 or later
- MySQL 10.4.32 or later
- Composer

### Quick Start
1. Clone the repository:
   ```bash
   git clone https://github.com/pdas544/ticket-support-system-main.git
   cd ticket-support-system-main
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the database:
   - Create a new database and user in MySQL.
   - Import the `ticketing_support.sql` file into the database.

4. Start the application:
   ```bash
   php -S localhost:8000 -t public
   ```

## 🎯 Usage

### Basic Usage

1) Use the Guest Menu -> Raise Ticket: Enter the Issue Details and Submit.-> Ticket Number is generated
2) Use the Guest Menu -> Check Ticket Status -> Enter the generated ticket number to check the status
3) New user can register and Sign-In with the given menu items.

### Advanced Usage
1) Perform CRUD operations on Tickets and Users using Admin Credentials
email: admin@admin.com
password: password

## 📁 Project Structure
```
ticket-support-system-main/
├── .env
├── .gitignore
├── composer.json
├── config/
│   ├── db.php
│   ├── email.php
│   └── routes.php
├── public/
│   ├── .htaccess
│   └── index.php
├── App/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Views/
│   └── partials/
├── migrations/
├── logs/
├── vendor/
└── README.md
```

## 🔧 Configuration
- **Configuration Files**: Modify `config/db.php` and `config/email.php` for database and email settings.


## 📝 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors & Contributors
- **Maintainer**: Priyabrata Das


## 🗺️ Roadmap
- **Planned Features**:
  - Add Middleware Support for refining the Authorization Logic
  - Add support for database migrations.
  - Add support JWT token for authentication instead of Sessions.

---

**Additional Guidelines:**
- Use modern markdown features (badges, collapsible sections, etc.)
- Include practical, working code examples
- Make it visually appealing with appropriate emojis
- Ensure all code snippets are syntactically correct for PHP
- Include relevant badges (build status, version, license, etc.)
- Make installation instructions copy-pasteable
- Focus on clarity and developer experience
