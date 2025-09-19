# Task Management Backend API

A robust Laravel-based REST API for managing tasks with features like task creation, updating, completion, reordering, and filtering. Built with modern PHP practices and includes comprehensive API endpoints for task management.

## 🚀 Tech Stack

- **Backend Framework**: Laravel 12.x
- **PHP Version**: 8.2+
- **Database**: SQLite (development)
- **Authentication**: Laravel Sanctum
- **Frontend Build**: Vite + Tailwind CSS 4.0
- **Testing**: PHPUnit
- **Code Quality**: Laravel Pint (PHP CS Fixer)

## 📋 Features

- ✅ Create, read, update, and delete tasks
- 🔄 Task reordering functionality
- ✅ Mark tasks as complete/incomplete
- 🔍 Search tasks by title
- 📊 Filter tasks by status (completed/pending)
- 🎨 Modern API with consistent response format
- 📝 Request validation
- 🧪 Comprehensive testing setup

## 🛠️ Local Development Setup

### Prerequisites

- PHP 8.2 or higher
- Composer
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd task-management-backend
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## 📚 API Endpoints

### Tasks

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tasks` | Get all tasks (with optional filtering) |
| POST | `/api/tasks` | Create a new task |
| GET | `/api/tasks/{id}` | Get a specific task |
| PUT | `/api/tasks/{id}` | Update a task |
| DELETE | `/api/tasks/{id}` | Delete a task |
| PATCH | `/api/tasks/reorder` | Reorder tasks |
| PATCH | `/api/tasks/{id}/complete` | Mark task as complete/incomplete |

### Query Parameters

**GET /api/tasks**
- `status`: Filter by status (`completed` or `pending`)
- `search`: Search tasks by title

### Request/Response Examples

**Create Task**
```bash
POST /api/tasks
Content-Type: application/json

{
    "title": "Learn Laravel",
    "description": "Complete Laravel tutorial"
}
```

**Response**
```json
{
    "success": true,
    "message": "Task created",
    "data": {
        "id": 1,
        "title": "Learn Laravel",
        "description": "Complete Laravel tutorial",
        "completed": false,
        "order": 1,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

**Reorder Tasks**
```bash
PATCH /api/tasks/reorder
Content-Type: application/json

{
    "tasks": [
        {"id": 1, "order": 2},
        {"id": 2, "order": 1}
    ]
}
```

## 🗄️ Database Schema

### Tasks Table
- `id` (Primary Key)
- `title` (String, Indexed)
- `description` (Long Text, Nullable)
- `completed` (Boolean, Default: false)
- `order` (Integer)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)


## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   └── TaskController.php
│   ├── Requests/Api/
│   │   ├── StoreTaskRequest.php
│   │   ├── UpdateTaskRequest.php
│   │   └── ReorderTaskRequest.php
│   └── Traits/
│       └── ResponseTrait.php
├── Models/
│   ├── Task.php
│   └── User.php
database/
├── migrations/
│   └── 2025_09_19_045025_create_tasks_table.php
└── database.sqlite
routes/
└── api.php
```

## 🔧 Development Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Run database migrations
php artisan migrate

# Run database rollback
php artisan migrate:rollback
```

## 📝 API Response Format

All API responses follow a consistent format:

**Success Response**
```json
{
    "success": true,
    "message": "Operation successful",
    "data": { ... }
}
```

**Error Response**
```json
{
    "success": false,
    "message": "Error message",
    "data": null
}
```

## 🚀 Deployment

1. Set up your production environment variables
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `php artisan migrate --force`
4. Configure your web server to point to the `public` directory

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and ensure they pass
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).