<p align="center">
  <img src="https://github.com/wbrframe/parkovochka/blob/main/public/landing/logo.svg" alt="Parkovochka logo">
</p>

---
Backend for moblie app for finding the nearest parking for your bike.

Project currently under development. 🚀 [parkovochka.space](https://parkovochka.space)

### Development

    docker compose up -d --build
    docker compose exec php composer install
    docker compose exec php composer app:recreate-database

### Requirements 🧐

* PHP 8
* Symfony 6
* PostgreSQL 15

