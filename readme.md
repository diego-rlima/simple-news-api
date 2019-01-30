# Starting with Laravel and Docker

This repository is my starter kit for developing with Laravel and Docker. It's really basics, but you'll be able to start developing without getting bored with the installation of PHP, Nginx and MySQL.
This ships with **PHP 7.3-fpm**, **Nginx 1.15.8-alpine** and **MySQL 5.7.25**.

## Requirements

You only need [Docker](https://docs.docker.com/install/) and [Docker Compose](https://docs.docker.com/compose/install/) installed.

## Getting Started

First, clone this repository or just download it.

````
$ git clone https://github.com/diego-rlima/laravel-docker.git app-folder
````

After, install the Laravel dependencies with Composer.

````
$ cd ./app-folder
$ docker run --rm -v $(pwd):/app composer install
````

Set the permissions on the project folder.

````
$ sudo chown -R $USER:$USER /path/to/app-folder
````

Create the .env file.

````
$ cp .env.example .env
````

Edit the .env file end put the default admin user info.

````
$ nano .env

DEFAULT_ADMIN_NAME=
DEFAULT_ADMIN_EMAIL=
DEFAULT_ADMIN_PASSWORD=
````

Finally, inside the project folder, just run:

````
$ docker-compose up -d
````

You can check if the containers are running

````
$ docker ps
````

If is everything ok, it will output something like:

````
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                                         NAMES
de320d716e6c        mysql:5.7.25        "docker-entrypoint.s…"   2 minutes ago   2 minutes ago    33060/tcp, 0.0.0.0:3360->3306/tcp             mysql_service
a53498ca08b6        diegoribeiro/php    "docker-php-entrypoi…"   2 minutes ago   2 minutes ago    9000/tcp                                      app
c3fafc29c50f        nginx:alpine        "nginx -g 'daemon of…"   2 minutes ago   2 minutes ago    0.0.0.0:8000->80/tcp, 0.0.0.0:8443->443/tcp   nginx_service
````

Next, set the the `APP_KEY` and the `JWT_SECRET` for the Laravel application.

````
$ docker-compose exec app php artisan key:generate
$ docker-compose exec app php artisan jwt:secret
````

Run the migrations.

````
$ docker-compose exec app php artisan migrator
````

**Note:** For this, the [Migrator package](https://github.com/artesaos/migrator) is used instead of the standard migrations.

## Accessing the Application

You can access the **application** by typing the address `http://localhost:8000`.

The **database** can be accessed by using the host `localhost` and the port `3360`.
The default database name, user, and password are, respectively, `laravel`, `root` and `secret`.

## License

Like Laravel, this repository is licensed under the [MIT license](https://opensource.org/licenses/MIT).
