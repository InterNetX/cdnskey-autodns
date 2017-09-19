# CDNSKEY AutoDNS
AutoDNS client that will poll a DNS server for CDNSKEY entries and update them via AutoDNS API.

# Requirements

* Authorative DNS server that deploys CDNSKEY records to zones (e.g. [Knot](https://www.knot-dns.cz/))
* [AutoDNS account](https://www.internetx.com/domains/autodns/)
* PHP 7
* PHP Composer
* Apache / NGINX web server

# Setup

CDNSKEY AutoDNS is a Laravel application. It can be installed and customized with a few steps.

## Clone via git

    git clone https://github.com/InterNetX/cdnskey-autodns.git

This will allow easy updates via git. It is also possible to download the ZIP file and extract it before following the next steps.

## Basic commands to setup the application

	composer install
	cp .env.example .env

You can now edit .env with your favorite editor and do some basic setup.

	APP_NAME="CDNSKEY AutoDNS DEMO"
	APP_ENV=production
	APP_KEY=
	APP_DEBUG=true
	APP_LOG_LEVEL=debug
	APP_URL=https://demo.cdnskey.example.org/

Next step is to setup the APP_KEY with artisan.

	./artisan key:generate

The application needs to write to data to some folders, please make sure they are writable for the webserver.

	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R ug+rwx storage bootstrap/cache

When you're running PHP FPM and have set-up the pool to run with the user you're performing the installation, these steps might be ommited.

## Setup the database

In this example we'll use MySQL on Ubuntu 16.04:

	apt-get install mysql-server

Create database and grant rights:

	CREATE DATABASE cdnskeydns DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
	GRANT ALL ON cdnskeydns.* TO 'cdnskeydns'@'localhost' IDENTIFIED BY '<password>';

MySQL isn't required, it's possible to configure any DB that is supported by Laravel.

The database configuration must be set in the .env configuration file.

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=cdnskeydns
	DB_USERNAME=cdnskeydns
	DB_PASSWORD="<password>"


Once the database is set-up, you need to create the database tables.

	./artisan migrate

## Configure AutoDNS account

You will require an AutoDNS API user that has the rights to perform domain updates (including namserver/DNSSEC). The function codes that need to be permitted are 0102, 0102007 and 0102008.

	AUTODNS_USER=cdnskey
	AUTODNS_CONTEXT=4
	AUTODNS_PASSWORD="<password>"
	AUTODNS_REPLYTO=youremail@example.com

## Configure the first user

Visit the installed web app in your browser and create your first user.

## Disable user registration

As soon as the initial users are created, you need to disable the public user registration in .env:

	AUTODNS_REGISTRATION=false

All users that can login, will still be able to create new users, if needed.

## Cron job

CDNSKEY checks are performed via a cron job, you need to setup manually like this:

	* * * * * php /installation-path/artisan schedule:run >> /dev/null 2>&1

If you want to force execution of the cron on the console, type

	./artisan cdnskey:check

## Webserver setup (nginx example)

	server {
		listen 80;
		listen [::]:80;
	
		listen 443 ssl;
		ssl_certificate fullchain.pem;
		ssl_certificate_key privkey.pem;
	
		# https only access
		if ($scheme != "https") {
			return 301 https://$host$request_uri;
		}
	
		root /home/demo/cdnskey-autodns/public;
	
		# Add index.php to the list if you are using PHP
		index index.php index.html index.htm index.nginx-debian.html;
	
		server_name demo.cdnskey.example.org;
	
		location / {
			try_files $uri $uri/ /index.php?$query_string;
		}
	
		# pass the PHP scripts to FastCGI server listening on socket.
		location ~ \.php$ {
			include snippets/fastcgi-php.conf;
			# Please note: there is one socket per version / pool
			fastcgi_pass unix:/run/php/php7.1-fpm.sock;
		}
	
		# deny access to .htaccess files, if Apache's document root concurs with nginx's one
		location ~ /\.ht {
			deny all;
		}
	
		location ~ /.well-known {
			allow all;
		}
	}

