# Sectors

Sectors is a [Symfony](https://symfony.com/) project.
Follow the steps below to set up and run the project locally.

## Getting Started

### Prerequisites

-   [Git](https://git-scm.com/)
-   [Docker](https://www.docker.com/)
-   [Composer](https://getcomposer.org/)
-   [Symfony CLI](https://symfony.com/download)

### Installation

1. Clone the repository:
    ```bash
    git clone git@github.com:margusliinev/sectors.git
    ```
2. Navigate to the project directory:
    ```bash
    cd sectors
    ```
3. Start the Docker containers:
    ```bash
    docker compose up -d
    ```
4. Install PHP dependencies:
    ```bash
    composer install
    ```
5. Run database migrations:
    ```bash
    php bin/console doctrine:migrations:migrate
    ```
6. Load data fixtures:
    ```bash
    php bin/console doctrine:fixtures:load
    ```
7. Start the Symfony server:
    ```bash
    symfony serve
    ```

### Accessing the Application

Once the Symfony server is running, you can access the application in your browser at `http://127.0.0.1:8000`.
