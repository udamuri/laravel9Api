## Install (Terminal)
	- git clone xxxx api
	- cd api
    - composer install
	- cp .env.example .env
    - php artisan key:generate
    - The key will be written automatically in your .env file.

## Database (laravel file)
    - config/database.php
	- create database laravel9_api
```
    edit .env
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel9_api
    DB_USERNAME=root
    DB_PASSWORD=
```
	
    - php artisan migrate
    - php artisan storage:link
	- php artisan vendor:publish
    
## Running Seeders (terminalgit status )
    -- Now you may use the db:seed Artisan command to seed your database. By default, the db:seed command runs the DatabaseSeeder class, which may be used to call other seed classes. However, you may use the --class option to specify a specific seeder class to run individually:
	-
	-
    - php artisan migrate:refresh --seed
	- php artisan storage:link
	- php artisan vendor:publish
