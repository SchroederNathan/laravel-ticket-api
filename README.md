# Ticket Management API 🎫

A RESTful API for managing support tickets built in Laravel. It allows users to create, update, and track tickets, with different permission levels for regular users and managers.

## Features

-   **RESTful API**: Follows REST principles with proper resource naming and HTTP methods
-   **Token-based Authentication**: Secure API access using Laravel Sanctum
-   **Role-based Permissions**: Different capabilities for managers and regular users
-   **Validation & Error Handling**: Request validation and error responses

## The Stack

-   **Framework**: Laravel 12
-   **Database**: MySQL
-   **Authentication**: Laravel Sanctum
-   **Documentation**: Scribe

## Getting Started

### Installation

1. Clone the repository:

    ```
    git clone https://github.com/SchroederNathan/laravel-ticket-api.git
    cd laravel-ticket-api
    ```

2. Install dependencies:

    ```
    composer install
    ```

3. Set up environment:

    ```
    cp .env.example .env
    ```

4. Configure your database in the `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=your-database-host
    DB_PORT=3306
    DB_DATABASE=tickets-please
    DB_USERNAME=your-username
    DB_PASSWORD=your-password
    ```

    AWS RDS is reccommended but any MySQL database will work

5. Run migrations:

    ```
    php artisan migrate
    ```

6. Seed the database (optional):

    ```
    php artisan db:seed
    ```

7. Start the development server:
    ```
    php artisan serve
    ```

## API Overview

The API is versioned (currently v1) and requires authentication for all endpoints.

### Authentication

To use the API, you need to:

1. Register a user or log in with existing credentials
2. Use the returned token in the Authorization header:
    ```
    Authorization: Bearer YOUR_TOKEN
    ```

### Main Endpoints

-   **Authentication**:

    -   `POST /api/v1/login` - Get an access token
    -   `POST /api/v1/logout` - Invalidate token

-   **Tickets**:

    -   `GET /api/v1/tickets` - List all tickets
    -   `POST /api/v1/tickets` - Create a ticket
    -   `GET /api/v1/tickets/{id}` - Get a specific ticket
    -   `PATCH /api/v1/tickets/{id}` - Update a ticket
    -   `PUT /api/v1/tickets/{id}` - Replace a ticket
    -   `DELETE /api/v1/tickets/{id}` - Delete a ticket

-   **Users**:

    -   `GET /api/v1/users` - List all users (managers only)
    -   `POST /api/v1/users` - Create a user (managers only)
    -   `GET /api/v1/users/{id}` - Get a specific user
    -   `PATCH /api/v1/users/{id}` - Update a user
    -   `DELETE /api/v1/users/{id}` - Delete a user (managers only)

-   **Author Tickets**:
    -   `GET /api/v1/authors/{id}/tickets` - Get tickets for a specific author
    -   `POST /api/v1/authors/{id}/tickets` - Create a ticket for an author
    -   `PATCH /api/v1/authors/{id}/tickets/{ticket_id}` - Update an author's ticket

### Permissions

The API uses a capability-based permission system:

-   **Regular Users** can:

    -   Create, view, update, and delete their own tickets
    -   View their own user information

-   **Managers** can:
    -   Perform all actions regular users can
    -   Create, view, update, and delete any ticket
    -   Create, view, update, and delete users
    -   View all users in the system

## Need Help?

Feel free to open an issue if you encounter any problems or have questions about the API.

Happy ticket managing! 🎫✨
