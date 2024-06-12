# API Boilerplate

## Introduction

API Boilerplate is the backend service crafted using Laravel 11 framework.


## Packages
- [Laravel Pint](https://laravel.com/docs/10.x/pint)
- [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki)
- [Security-checker](https://github.com/enlightn/security-checker)
- [Pest](https://pestphp.com/docs/installation)
- [PHPStan](https://phpstan.org/user-guide/getting-started)
- [RECTOR](https://getrector.com/)
- [Infection](https://infection.github.io/guide/)

## Prerequisites

- [Composer](https://getcomposer.org/)
- [PHP >= 8.3](http://www.php.net/)

## Boilerplate Docker Setup

### Cloning the Repository

```bash
git clone git@gitlab.bastrucks.com/basworld/boilerplates/api.git boilerplate-api
cd boilerplate-api
```

### Initializing Docker
Run the initialization script to set up the Docker environment.
During the initialization, a port conflict error may occur if you are using a reverse proxy. Nevertheless, the application will proceed to start utilizing the current reverse proxy, eliminating the need for the creation of a new one.
```bash
./docker/init.sh
```

## Accessing API Boilerplate Locally
You can access your application locally by navigating to the URL `https://boilerplate.bas.localhost`

## Accessing API Boilerplate Documentation Locally
You can access your application API documentation locally by navigating to the URL
`https://boilerplate.bas.localhost/api/documentation`

