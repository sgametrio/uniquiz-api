# Uniquiz backend

## Getting Started ((Automate this please))
* Clone this repo
* Serve your backend with Laradock and type: `docker-compose up -d nginx mysql`
* `composer install`
* Copy `.env.example` to `.env` and change default passwords and usernames (!!) (both uniquiz-api and laradock)
* Create DB, USER and GRANT permissions (skip this with my laradock setup)
* Connect to `/appKey` and copy the random string to your `.env` file at `APP_KEY` entry
* Make migrations on the DB using `php artisan migrate`
* In your PHP `.env` set:

		DB_HOST=mysql

* Enjoy

## TO-DOs
* UUIDs instead of IDs
* CRUD for every model (boring) (only admin)
* Create and Read for every model (every user)

## Laravel useful functions to use
* [API authentication](https://laravel.com/docs/5.5/passport)
* OAuth2 support for login (later)
* Database Pagination for 10+ results
* [Validation](https://laravel.com/docs/5.5/validation) of incoming POST AJAX request

## HOW-TOs (dev)
* Migrations:

	```bash
	env DB_HOST=127.0.0.1 php artisan migrate
	```

* Open PHPMyAdmin:

	```bash
	cd laradock-uniquiz-backend
	docker-compose up -d nginx mysql phpmyadmin
	```
	Connect to `http://localhost:8080/` and put your custom DB_HOST, MYSQL_USER, MYSQL_PASSWORD (you can find them in `.env` file)



# Uniquiz Frontend

* Scaffold uniquiz-frontend and pass all routes /* to VueJS frontend (not sure how to do it)
* Use __as it is__ uniquiz-frontend if possible

