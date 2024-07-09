# Task Management Laravel Application

## Introduction

This is a simple Laravel web application designed for task management. The application allows users to create, edit, delete, and reorder tasks with drag-and-drop functionality. Tasks are prioritized based on their order, with the highest priority task at the top. Additionally, users can associate tasks with projects and filter tasks based on the selected project.

## Features

- **Create Task**: Save task name, priority, and timestamps.
- **Edit Task**: Modify task details.
- **Delete Task**: Remove tasks from the list.
- **Reorder Tasks**: Drag and drop tasks to reorder them. Priority is updated automatically based on the new order.
- **Project Functionality**: Assign tasks to projects and view tasks associated with a specific project.

## Requirements

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (for front-end dependencies)
- Laravel 10.x

## Installation

1. **Clone the Repository**:
extract the repository to a location     ```

2. **Environment Configuration**:
    - Import the database file from the database folder into your mysql server
     
     
    - Update the `.env` file with your database credentials:
       
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password
    

3. **Open an IDE**:
- use visual studio code to open the application
   

4. **Start the Application**:   
   - open IDE terminal and type the following command
   php -S localhost:9000

    The application will be available at `http://localhost:9000`.

## Usage


1. **Access the Application**:
    - Open your web browser and navigate to `http://localhost:9000`.
    - login using the following credentials
    - email: chem@gmail.com
    - password: 12345678900


2. **Filter by Project**:
    - Create Project first because every task is associated in a project.

3. **Create a Task**:
    - Click on the "Create Task" button.
    - Fill in the task name and select a project from the dropdown (if any).
    - Click "Save".

4. **Edit a Task**:
    - Click the edit icon next to the task you wish to edit.
    - Update the task details and click "Save".

5. **Delete a Task**:
    - Click the delete icon next to the task you wish to remove.

6. **Reorder Tasks**:
    - Drag and drop tasks to reorder them.
    - The priority will be automatically updated based on the new order.


## Code Structure

- **Models**:
    - `Task`: Represents a task.
    - `Project`: Represents a project.

- **Controllers**:
    - `TaskController`: Handles task-related actions.
    - `ProjectController`: Handles project-related actions.

- **Views**:
    - Blade templates for displaying tasks and projects.

- **Routes**:
    - Web routes for task and project management.

## Notes

- Ensure your MySQL database is running and accessible.
- Run `npm run watch` during development for live reloading of assets.



## Conclusion

This README provides the necessary steps to set up, use, and deploy the Task Management Laravel Application. For any issues or further assistance, please refer to the Laravel documentation or contact the project maintainer.

