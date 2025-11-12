# ticket-support-system-main

## 🚀 Overview
The `ticket-support-system-main` is a robust PHP-based ticketing system designed to streamline IT support processes. This system allows users to create, view, and manage support tickets efficiently. It is ideal for organizations looking to enhance their IT support capabilities and improve customer satisfaction.

## ✨ Features
- **User Authentication**: Secure login and registration for users and agents.
- **Ticket Management**: Create, view, and manage tickets with detailed status tracking.
- **Email Notifications**: Automated email notifications for ticket updates.
- **Role-Based Access Control (RBAC)**: Different access levels for users, agents, and admins.
- **Dashboard**: Customizable dashboards for users, agents, and admins to monitor ticket statistics.
- **Error Handling**: Centralized error handling and logging for better debugging.

## 🛠️ Tech Stack
- **Programming Language**: PHP
- **Frameworks and Libraries**:
  - [AltoRouter](https://github.com/altorouter/altorouter)
  - [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- **Database**: MySQL
- **Version Control**: Git

## 📦 Installation

### Prerequisites
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

4. Configure environment variables:
   - Create a `.env` file in the root directory with the following content:
     ```env
     DB_HOST=localhost
     DB_NAME=ticketing_support
     DB_USER=root
     DB_PASS=
     ```

5. Start the application:
   ```bash
   php -S localhost:8000 -t public
   ```

### Alternative Installation Methods
- **Docker**: Use the provided Dockerfile to set up the application in a container.
- **Composer**: Install the project using Composer.

## 🎯 Usage

### Basic Usage
```php
// Example: Creating a new ticket
$ticket = new Ticket();
$ticket->create($user_id, $subject, $description);
```

### Advanced Usage
- **Customizing Email Notifications**: Modify the `config/email.php` file to change email settings.
- **Adding Custom Middleware**: Implement additional middleware for custom authentication or authorization logic.

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
- **Maintainer**: [Your Name]
- **Contributors**: [List of contributors]


## 🗺️ Roadmap
- **Planned Features**:
  - Add Migration Support for securing end points
  - Add support for database migrations.
  - Enhance model validation.
- **Known Issues**:
  - [Issue 1](https://github.com/pdas544/ticket-support-system-main/issues/1)
  - [Issue 2](https://github.com/pdas544/ticket-support-system-main/issues/2)
- **Future Improvements**:
  - Add support for categorizing tickets into severity levels as High, Normal, and Low.


---

**Additional Guidelines:**
- Use modern markdown features (badges, collapsible sections, etc.)
- Include practical, working code examples
- Make it visually appealing with appropriate emojis
- Ensure all code snippets are syntactically correct for PHP
- Include relevant badges (build status, version, license, etc.)
- Make installation instructions copy-pasteable
- Focus on clarity and developer experience
