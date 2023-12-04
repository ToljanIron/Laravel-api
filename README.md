### Welcome to my repository

## Requirements
- Docker
- GIT CLI

## Installation and Setup

1. Clone the repository:

   ```shell 
   git clone https://github.com/ToljanIron/Laravel-api.git
   cd Laravel-api
   
2. Navigate to the api directory and copy the .env.example file to .env:
   ```shell
   
   cd api
   cp .env.example .env
   
3. Return to the project's root directory:
   ```shell
   
   cd ..
   
4. Start the Docker containers using docker-compose:
   ```shell
   
   docker-compose up -d
   
5. Check if the composer container is running. If it's not, start it:
    ```shell
    
    cd api
    php artisan key:generate
    docker exec -it api-php php artisan migrate
