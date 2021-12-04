<p align="center">
<img src="/public/images/librio-small.png"/>
</p>

<h3 align="center">Librio</h3>

<p align="center">
  Librio is an open source library system, created for small libraries who don't want to invest in an expensive system.
</p>

## Requirements
* PHP 7.4
* Database (eg: MySQL, PostgreSQL, SQLite)
* Web Server (eg: Apache, Nginx, IIS)

## Docker

It is possible to containerise Librio using the [`docker-compose`](docker-compose.yml) file. Here are a few commands:

```bash
# Build the app
docker build -t librio .

# Run the app
docker-compose up -d

# Make sure you the dependencies are installed
docker-compose exec web composer install

# Stream logs
docker-compose logs -f web

# Access the container
docker-compose exec web /bin/sh

# Stop & Delete everything
docker-compose down -v
```
