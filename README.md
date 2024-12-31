## Table of Contents

-   [Table of Contents](#table-of-contents)
-   [Project Overview](#laravel-shopping-cart-api)
-   [Features](#features)
-   [Tech Stack](#tech-stack)
-   [Installation](#installation)
-   [API Reference](#api-reference)
-   [Service Repository Pattern](#service-repository-pattern)
-   [Directory Structure](#directory-structure)
-   [Testing](#testing)
-   [Contributing](#contributing)
-   [License](#license)

# Laravel Shopping Cart API

**Project Overview**

This project implements a shopping cart functionality for a shopping system using Laravel. It is designed as a RESTful API that follows the Service Repository pattern, ensuring a clean architecture and separation of concerns. The API allows users to manage their shopping carts, including adding products, viewing cart contents, and checking out.

## Features

-   **User Authentication**: Users can register and log in to manage their carts.
-   **Cart Management**: Users can create, update, and delete carts.
-   **Product Management**: Users can add products to their carts and view the cart contents.
-   **Checkout Process**: Users can proceed to checkout, providing necessary details for order processing.
-   **RESTful API**: All functionalities are accessible via a RESTful API.

## Tech Stack

**Laravel:** PHP framework for building the API.

**Eloquent ORM:** For database interactions.

**Service Repository Pattern:** To separate business logic from data access logic.

**MySQL:** Database for storing user and cart data.

## Installation

Prerequisites

-   PHP 7.4 or higher
-   Composer
-   MySQL
-   Laravel Installer

Steps to Install

1- **Clone the Repository**:

```bash
git clone https://github.com/mhdGit402/Shopping-Cart-API.git
cd laravel-shopping-cart-api
```

2- **Install Dependencies**:

```bash
composer install
```

3- **Set Up Environment**:

-   Copy the `.env.example` file to `.env`

```bash
cp .env.example .env
```

-   Update the `.env` file with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4- **Generate Application Key**:

```bash
php artisan key:generate
```

5- **Run Migrations**:

```bash
php artisan migrate
```

6- **Seed the Database (Optional)**:

If you want to populate the database with sample data, run:

```bash
php artisan db:seed
```

7- **Start the Development Server**:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

## API Reference

#### **User Management**

**1- Create User**

-   **Endpoint**: `POST/user`
-   **Description**: Creates a new user in the system.
-   **Request Body**:

```bash
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "securepassword"
}
```

-   **Response**:
    -   **201 Created**: Returns the created user object with API token.
    -   **400 Bad Request**: If validation fails.

**2- Get User Token**

-   **Endpoint**: `GET/user/{email}`
-   **Description**: Retrieves the API token for a specific user.
-   **Authorization**: Requires `view tokens` permission.

-   **Response**:
    -   **200 OK**: Returns the user's API token.
    -   **403 Forbidden**: If the user does not have permission.

#### **Product Management**

**1- Resource Routes for Products**

-   **Endpoint**: `/product`
-   **Description**: Retrieves the API token for a specific user.
-   **Methods**:

    -   `GET /product`: List all products.
    -   `POST /product`: Create a new product.
    -   `GET /product/{id}`: Retrieve a specific product.

-   **Response**:
    -   **200 OK**: Returns the product data.
    -   **201 Created**: Returns the created product data.
    -   **404 Not Found**: If the product does not exist.

#### **Shopping Cart Management**

**1- View All Carts**

-   **Endpoint**: `GET /cart`
-   **Description**: Lists all carts.
-   **Authorization**: Requires `view all carts` permission

-   **Response**:
    -   **200 OK**: Returns an array of carts.
    -   **403 Forbidden**: If the user does not have permission.

**2- Get Specific Cart**

-   **Endpoint**: `GET /cart/{id}`
-   **Description**: Retrieves a specific cart by ID.

-   **Response**:
    -   **200 OK**: Returns the cart data.
    -   **404 Not Found**: If the cart does not exist.

**3- Add to Cart**

-   **Endpoint**: `POST /cart/add`
-   **Description**: Adds a product to the user's cart.
-   **Request Body**:

```bash
{
    "product_id": 1,
    "quantity": 2
}
```

-   **Response**:
    -   **200 OK**: Returns the updated cart.
    -   **404 Not Found**: If the product does not exist.

**4- Remove from Cart**

-   **Endpoint**: `DELETE /cart/remove`
-   **Description**: Removes a product from the user's cart.
-   **Request Body**:

```bash
{
    "product_id": 1
}
```

-   **Response**:
    -   **200 OK**: Returns the updated cart.
    -   **404 Not Found**: If the product does not exist in the cart.

## Service Repository Pattern

This project utilizes the Service Repository pattern to separate the business logic from the data access logic. Each service handles the business rules, while the repository manages the data interactions with the database.

**Directory Structure**

-   **app/Models**: Contains Eloquent models.
-   **app/Repositories**: Contains repository classes for data access.
-   **app/Services**: Contains service classes for business logic.
-   **app/Http/Controllers**: Contains API controllers.

## Testing

To run the tests, use the following command:

```bash
php artisan test
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License. See the LICENSE file for details.
