# php-redirect-app

A simple self-hosted url shortener.

* Shortlink - URL map stored in sqlite3 db

# Requirements

* A web server capable of interpreting php.
* Must be capable of interpeting `.htaccess` 

# Installation

* Extract this into the directory that is served (e.g. /var/www/html/r/)
* goto `/install.php` and set a passphrase. This passphrase will allow you to create, delete, view links.

# Usage

Assuming you've installed it onto `http://foo/r/`

* To create a new short url, goto `http://foo/r/add`
* To delete a new short url, goto `http://foo/r/delete`
* To list a new short url, goto `http://foo/r/list`

# Note

If your server does not support https, then using this service on untrusted network will result in sending the form data in plain text, including the auth code. Please do not use sensentive passphrase for this service. 