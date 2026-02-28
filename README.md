🍽️ Restaurant Management System – Backend API

A RESTful backend API built using Laravel for restaurant management authentication and user handling.

This project currently focuses on secure authentication using JWT with refresh token rotation and Redis-based token revocation.

🚀 Tech Stack

Framework: Laravel

Language: PHP

Authentication: JWT (Access + Refresh Token)

Cache: Redis

Database: MySQL

Performance Engine: Laravel Octane

API Documentation: Swagger / OpenAPI

📌 Current Features

 User Registration

 Secure Login

 JWT Access Token

 JWT Refresh Token

 Refresh Token Rotation

 Refresh Token Revocation (Redis-based)

 Secure Logout

 Bearer Token Authentication

 Service Layer Architecture

 DTO Pattern Implementation

🔐 Authentication Flow

User registers via /api/register

User logs in via /api/login

System returns:

access_token

refresh_token

Access token is used for protected API requests.

Refresh token is used to generate a new access token.

On logout:

Access token is invalidated

Refresh token is removed from Redis

🔑 API Endpoints
Method	Endpoint	Description
POST	/api/register	Register new user
POST	/api/login	Login and receive tokens
POST	/api/refresh	Refresh access token
POST	/api/logout	Logout and revoke tokens
🔐 Example Authorization Header
Authorization: Bearer {access_token}
🧠 Security Implementation

Password hashing using bcrypt

Access & Refresh token separation

Refresh token rotation

Refresh token storage in Redis

Token revocation on logout

Bearer token middleware protection

Stateless JWT authentication

🏗️ Architecture Overview

The project follows a clean backend architecture:

Controllers → Handle HTTP requests

Service Layer → Business logic

DTOs → Structured data transfer

Middleware → JWT authentication

Redis → Refresh token validation

MySQL → Persistent storage

🛠️ Installation Guide
1️⃣ Clone Repository
git clone https://github.com/your-username/restaurant-management.git
cd restaurant-management
2️⃣ Install Dependencies
composer install
3️⃣ Configure Environment

Copy environment file:

cp .env.example .env

Update .env file:

APP_NAME=RestaurantAPI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurant_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
QUEUE_CONNECTION=sync

JWT_SECRET=

Generate application key:

php artisan key:generate

Generate JWT secret:

php artisan jwt:secret
4️⃣ Run Database Migrations
php artisan migrate
5️⃣ Start Server with Octane
php artisan octane:start
📂 Project Structure
app/
 ├── DTOs/
 ├── Services/
 ├── Models/
 ├── Http/
 │   ├── Controllers/
 │   ├── Middleware/
routes/
config/
database/
📊 Example Login Response
{
  "success": true,
  "status": 200,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "Bearer",
  "expires_in": 3600
}
📈 Performance Optimization

High concurrency support using Laravel Octane

Stateless authentication system

Redis-backed refresh token validation

Optimized database queries

📌 Future Roadmap

 Role-Based Access Control (RBAC)

 Restaurant Management Module

 Order Management

 Billing & Invoice System

 Docker Integration

 CI/CD Pipeline

 Production Deployment on AWS

👨‍💻 Author

Yahi
Backend Developer | Laravel API Engineer

If you want next version I can give:

🔥 GitHub portfolio optimized version

🔥 Enterprise production-level README

🔥 Add architecture diagram section

🔥 Add Docker + AWS deployment section

Tell me which level you want next.