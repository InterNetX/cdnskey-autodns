# CDNSKEY AutoDNS
AutoDNS client that will poll a DNS server for CDNSKEY entries and update them via AutoDNS API.

# Setup

## Setup the database

In this example we'll use MySQL on Ubuntu 16.04:

	apt-get install mysql-server

Create database and grant rights:

	CREATE DATABASE cdnskeydns DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
	GRANT ALL ON cdnskeydns.* TO 'cdnskeydns'@'localhost' IDENTIFIED BY '<password>';


MySQL isn't required, it's possible to configure any DB that is supported by Laravel.

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

