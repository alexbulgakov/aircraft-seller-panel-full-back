# Fullstack aircraft seller panel - backend

This is the backend part of the application. Instructions for its installation can be found in the "How to install" section. The backend consists of containerized MySQL, Nginx, and PHP code, providing API services. It accepts requests from the frontend, for example, the add method - adds a new record to the database.

## Table of contents

- [Overview](#overview)
  - [The challenge](#the-challenge)
  - [Links](#links)
  - [How to install](#how-to-install)
- [My process](#my-process)
  - [Built with](#built-with)

## Overview

### The challenge

Users should be able to:

- search through the list of airplanes
- sort by clicking on the column header
- edit airplane information
- add an airplane
- view information about the airplane by clicking on its name
- delete an airplane from the list

### Links

- Solution URL: [github.com/alexbulgakov/aircraft-seller-panel-full-back](https://github.com/alexbulgakov/aircraft-seller-panel-full-back)

### How to install

Download [Docker Desktop](https://www.docker.com/products/docker-desktop/), if it is not already installed.

Add a new line to the hosts file:
```
127.0.0.1 task.loc
```
On Linux and macOS, this file is located at /etc/hosts, on Windows — C:\Windows\System32\drivers\etc\hosts. Administrator rights are required for editing.

Launch app:
```bash
docker-compose up -d
```

Upon the first launch, all the necessary images will be downloaded. Subsequent launches will only start the images if they have already been downloaded.

After a successful launch, the application will be accessible at http://task.loc.

Stop app:
```bash
docker-compose down
```
Stopping and restarting may be necessary if you have modified the nginx configuration.

Execute one of the Composer commands:
```bash
docker-compose exec -w /var/www/task.loc php composer <команда>
```
For example, `composer install` will be executed as follows:
```bash
docker-compose exec -w /var/www/task.loc php composer install
```

The following details are used to connect to the MySQL database:

- Host: mysql
- Username: root
- Password: secret
- Database name: task
- Port: 3306

## My process

### Built with

- [Docker](https://www.docker.com/)
- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)
