# Gift Funnel Project

Welcome to the Gift Funnel project developed by **Betatech**.

## Project Languages & Tools

-   **Laravel** 11
-   **PHP** 8.2
-   **Composer** 2+
-   **Tailwind CSS**
-   **AdminLTE Package**

## Installation Instructions

1. **Clone the repository:**

    ```bash
    git clone https://shakib@bitbucket.org/betatechco/gift-funnel.git

    ```

2. **Navigate to your project directory:**

    ```bash
    cd your-laravel-project

    ```

3. **Install PHP dependencies:**
    ```bash
    composer install
    ```
4. **Set up environment configuration:**

    ```bash
    cp .env.example .env
    php artisan key:generate

    ```

5. **Edit the .env file to match your database configuration:**

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    ```

6. **Run migrations for a fresh project:**
    ```bash
    php artisan migrate
    ```
7. **Seed the database with necessary data:**

    ```bash
    php artisan db:seed --class=PermissionTableSeeder
    php artisan db:seed --class=CreateAdminUserSeeder

    ```

8. **Install Node.js dependencies and build assets:**
    ```bash
    npm install
    npm run build
    ```
9. **Start the development server:**

    ```bash
    php artisan serve

    ```

10. **Default Login for Superadmin**
    admin@gmail.com/12345678

## Please Note

You can modify the following values in the .env file:

1. FUNNEL_NAME: Set the default funnel name.
2. PROJECT_NAME: Set the Admin Dashboard project name.

### Amazon Configaration:

1. AMAZON_ORDER_API: Specify the Amazon Order API.
2. AMAZON_TOKEN: Set the Amazon Token.

### Gorgias Service Configuration:

1. GORGIAS_SERVICE_ENABLE: If true, the Gorgias service will be called to create a ticket.
2. GORGIAS_BASE_API_URL: Should be in the format https://audienhearing.gorgias.com/api/tickets.
3. GORGIAS_USERNAME: Your Gorgias username.
4. GORGIAS_PASSWORD: Your Gorgias password.
5. GORGIAS_PURCHASED_FROM: Default value is Amazon.
6. GORGIAS_TICKET_SUBJECT: Subject of the ticket (e.g., Critical Review from Gift Funnel).
7. GORGIAS_TICKET_TAG_NAME: Name of the ticket tag or group.
8. GORGIAS_TICKET_TAG_ID: Group ID (e.g., 1133155).

### Shopify Configuration:

1. SHOPIFY_DOMAIN: Shopify URL (e.g., budget-hearing-aids.myshopify.com).
2. SHOPIFY_ACCESS_TOKEN: Provided access token (e.g., shpat_72f590495e18defd22305d****\*****).
3. ORDER_VARIANT_ID: Ordered product ID (e.g., 693235662\*\*\*\*).
4. ORDER_PRODUCT_NAME: Name of the ordered product.
5. ORDER_PRODUCT_TITLE: Title of the ordered product.

### Amazon ASIN

-   You can add or update Amazon ASIN values in config/amazon.
