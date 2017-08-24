# Uniquiz backend

## TO-DOs
* Switch to Lumen (micro-framework) (not sure about this)
* UUIDs instead of IDs

## Laravel useful functions to use
* [API authentication](https://laravel.com/docs/5.4/passport)
* OAuth2 support for login (later)
* Database Migrations every time a new model come up
* Database Pagination for 10+ results

## HOW-TOs (dev)
* Migrations:

	If `.env` DB_HOST=mysql then

	```bash
	env DB_HOST=127.0.0.1 php artisan migrate
	```

* Open PHPMyAdmin:

	```bash
	cd laradock-uniquiz-backend
	docker-compose up -d nginx mysql phpmyadmin
	```
	Connect to `http://localhost:8080/` and put your custom DB_HOST, MYSQL_USER, MYSQL_PASSWORD (you can find them in `.env` file)

## HOW-TOs (prod) ((Automate this please))
* Getting started

	* How to connect to MYSQL command line:

		```bash
		cd laradock-uniquiz-backend
		docker-compose exec mysql bash
		mysql -u root -p
		# Now enter your root's password
		```

	* Create `uniquiz` DB, MYSQL user for your DB and grant him all privileges on `uniquiz` DB.

		Change then `.env` MYSQL's user and password connection.

		```bash
		mysql> CREATE DATABASE uniquiz;
		mysql> CREATE USER 'uniquiz'@'localhost' IDENTIFIED BY 'your_password';
		mysql> GRANT ALL ON uniquiz.* TO 'uniquiz'@'localhost';
		```

	* Make migrations on your DB using `php artisan migrate`

	* Change .env default passwords and usernames (!!) (both laravel app and laradock)

	* Enjoy your app by serving it with: `docker-compose up -d nginx mysql`


# Uniquiz Frontend

* Scaffold uniquiz-frontend and pass all routes /* to VueJS frontend (not sure how to do it)
* Use __as it is__ uniquiz-frontend if possible

