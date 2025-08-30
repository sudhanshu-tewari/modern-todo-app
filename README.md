# Modern Todo App

A modern, responsive Todo application built with Laravel and Tailwind CSS.

## Features

- ✅ Create, read, update, and delete todos
- 🎯 Priority levels (Low, Medium, High)
- 📅 Due dates
- ✔️ Mark todos as complete/incomplete
- 📱 Fully responsive design
- 🎨 Modern UI with smooth animations
- 📊 Todo statistics (completed vs pending)

## Installation

1. Navigate to the project directory:
   ```bash
   cd todoApp
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. (Optional) Seed with sample data:
   ```bash
   php artisan db:seed --class=TodoSeeder
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

8. Visit `http://localhost:8000` in your browser

## Usage

- **Add Todo**: Fill out the form on the left to create a new todo
- **Mark Complete**: Click the circle icon next to any todo to toggle completion
- **Edit Todo**: Click the edit icon to modify an existing todo
- **Delete Todo**: Click the trash icon to remove a todo
- **Priority Colors**: 🔴 High, 🟡 Medium, 🟢 Low

## Technologies Used

- Laravel 12
- Tailwind CSS
- Font Awesome Icons
- SQLite Database
- Responsive Design
