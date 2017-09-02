# Tax Crud

## Installation with docker

The easy way to start the application is using docker, so run:

```bash
$ docker-compose up --build
```

After the containers is running, install dependencies:

```bash
$ docker-compose run zf composer install
```

## Installation without docker

Considering if you have php5.6+ and composer installed, run:

```bash
$ composer install
```

After this, you have to configure database, open config/autoload/global.php, 
and edit with your db configurations.

## Create Database Schema

If you are using docker, run migrations with:

```bash
$ docker-compose run zf vendor/bin/phinx migrate
```

If you are not using docker, simply run:

```bash
$ vendor/bin/phinx migrate
```

## Inserting Operators

If you are using docker, run operator seed with:

```bash
$ docker-compose run zf vendor/bin/phinx seed:run -s OperatorSeed
```

If you are not using docker, simply run:

```bash
$ vendor/bin/phinx seed:run -s OperatorSeed
```

