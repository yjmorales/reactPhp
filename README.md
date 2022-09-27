## Yenier Jimenez 's ReactPHP

This project is an example of how to use the [ReactPHP](https://reactphp.org/) library. The following components are
used:

- [EventLoop](https://reactphp.org/event-loop)
- [Promises](https://reactphp.org/promise)
- [Async](https://reactphp.org/async/)

### Installation

    - git clone git@github.com:yjmorales/reactPhp.git
    - cd reactPhp
    - composer install

### Virtual host

In case this site is hosted by apache, the following is the VHost configuration:

    <VirtualHost *:80>
        ServerName reactphp.yjm
        ServerAlias reactphp.yjm
        DirectoryIndex index.php
        ServerAdmin webroot@localhost
        DocumentRoot "/var/www/html/public"
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
        <Directory "/var/www/html/public">
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
            Require all granted
            <IfModule mod_rewrite.c>
                RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^.*$ /index.php
            </IfModule>
        </Directory>
    </VirtualHost>

### Update /etc/hosts file

In case apache is running on the same development station a new entry to the local
host file is needed:

{local_ip} your_domain.com

Where **local_ip** is the ip of the local server ip

### Docker

Also, it is added in this project a docker environment to run this project.

Requirements: Docker

How to run the container:

    docker-compose up --build -d

Inside `docker-compose.yaml` file you can change the default port for the web container.   
Inside `dockerization/web/Dockerfile` file there are all the resources needed by the docker container.