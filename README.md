## Getting started:
**These Instructions are only for the project setup, and project specifications exist in [src folder](https://github.com/ahmedmohamed24/TMDB-Seeder/tree/main/src)**
1. Fork this Repository

    ``` git clone https://github.com/ahmedmohamed24/TMDB-Seeder.git movies-seeder ```
1. change the current directory to project path ex:

      ``` cd movies-seeder ```
1. change your database credentials in *docker-compose.yml* file

    ```
    environment:
      MYSQL_DATABASE: movies
      MYSQL_USER: root
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: secret
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql

    ```
    *docker will create your database with the provided credentials during installation process*

1. ``` docker-compose build && docker-compose up -d ```


1. Install dependencies with composer

      ```docker-compose exec php composer install ```
1. copy `.env-example` to `.env`
  ``` cp .env-example .env ```
1. set your **DB** and **TMD_API_KEY** credentials in `.env`
1. run migrations

     ``` docker-compose exec php php /var/www/html/artisan migrate ```
1. run testcases

      ``` docker-compose exec php php /var/www/html/artisan test```
1. run **Scheduler**

      ``` docker-compose exec php php /var/www/html/artisan schedule:work```
1. import `Movies-Seeder.postman_collection.json` file in postman to test endpoints