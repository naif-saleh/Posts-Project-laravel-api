# 📝 Laravel Post API

A RESTful API built with Laravel that allows users to register, authenticate, and manage posts, categories, comments, likes, and dislikes. All protected routes require authentication via Laravel Sanctum.

## 📦 Requirements

- PHP 8.1+
- Composer
- Laravel 11+
- Sanctum
- MySQL or other supported DB

---

## 🚀 Getting Started

1. Clone the repository:
```bash
https://github.com/naif-saleh/Posts-Project-laravel-api.git
cd post-api
```
Install dependencies:
```
composer install
```
Create and configure .env:
```

```bash
cp .env.example .env
php artisan key:generate
```

Install Sanctum api

```
php artisan install
```
Run migrations:

```
php artisan migrate
```
Start the development server:

```
php artisan serve
```
🔐 Authentication
Register

```
POST /api/register

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```
Login
```
POST /api/login

{
  "email": "john@example.com",
  "password": "password"
}
```
Returns a token you must use in the Authorization header:

Logout
```
Authorization: Bearer {token}
POST /api/logout
```
📁 Endpoints
Categories
Method	Endpoint	Description

```
GET	/api/categories	Get all categories
POST	/api/categories	Create a new category
GET	/api/categories/{id}	Show a category
PUT	/api/categories/{id}	Update a category
DELETE	/api/categories/{id}	Delete a category
```

Posts
Method	Endpoint	Description

```
GET	/api/posts	List all posts
POST	/api/posts	Create a new post
GET	/api/posts/{id}	Show a single post
PUT	/api/posts/{id}	Update a post
DELETE	/api/posts/{id}	Delete a post
```
Comments
Method	Endpoint	Description

```
GET	/api/comments	List all comments
POST	/api/comments	Add a new comment
GET	/api/comments/{id}	Show a comment
PUT	/api/comments/{id}	Update a comment
DELETE	/api/comments/{id}	Delete a comment
```
Likes
Method	Endpoint	Description

```
POST	/api/posts/like	Like a post
POST	/api/posts/unlike	Remove like
```
Dislikes
Method	Endpoint	Description
```
POST	/api/posts/dislike	Dislike a post
POST	/api/posts/undislike	Remove dislike
```
📂 Example Headers for Authenticated Requests

```
Authorization: Bearer {your_token}
Accept: application/json
Content-Type: application/json
```
🧪 Testing
Use Postman or any API client to test the routes. Ensure you send the Authorization header with your token after login.

👨‍💻 Author
Name: Naif Saleh

GitHub: @naif-saleh
