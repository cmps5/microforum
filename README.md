# MicroForum

**MicroForum** is a simple **web forum built with PHP and MySQL** that allows users to create accounts, log in, and publish posts in a public discussion forum.

This project was developed as an exercise to practice fundamental concepts such as:

- PHP web development
- MySQL database interaction
- User authentication
- CRUD operations
- Basic web application structure

---

# Features

- User registration
- User login and logout
- Avatar upload
- Create new posts
- Edit existing posts
- View posts in the forum
- Shared layout with header and footer
- Automatic database installation script

---

# Technologies

- PHP
- MySQL
- PDO for database connection
- HTML
- CSS

---

# Project Structure
```
microforum/
│
├── add_post.php # Create a new post
├── editor_post.php # Edit a post
├── forum.php # Main forum page
├── index.php # Homepage
│
├── login.php # Login page
├── login_validation.php # Login validation logic
├── logout.php # Logout script
├── signup.php # User registration
│
├── install.php # Database installation script
├── config.php # Database configuration
│
├── header.php # Shared header layout
├── footer.php # Shared footer layout
│
├── css/
│ └── main.css # Stylesheet
│
└── img/
├── logo.png
└── avatar/ # User avatars
```

---

# Installation

## 1. Clone the repository

```bash
git clone <repository-url>
cd microforum 
```

## 2. Configure the database
Edit the file:
```
config.php
```
Example configuration:
```php
$data_base = "forum";
$host = "localhost";
$user = "root";
$db_password = "";
```

## 3. Run the installation script

Open the following URL in your browser:
```
http://localhost/microforum/install.php
```
This script will automatically:
 - Create the database
 - Create the users table
 - Create the posts table

## 4. Access the application

After installation, open:
```
http://localhost/microforum
```

# Database Structure

The system uses two main tables.

### users

| Field    | Type    |
| -------- | ------- |
| id_user  | INT     |
| username | VARCHAR |
| password | VARCHAR |
| avatar   | VARCHAR |

### posts

| Field     | Type     |
| --------- | -------- |
| id_post   | INT      |
| id_user   | INT      |
| title     | VARCHAR  |
| content   | TEXT     |
| post_date | DATETIME |

# Future Improvements
Possible enhancements for the project:
- Comment system
- Likes or reactions
- User profiles
- etc.

# LICENSE

This project is licensed under the **MIT License**.
See the [LICENSE](LICENSE) file for more information.

