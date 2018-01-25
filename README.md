# The Liturgists API

This is the project for the api provider for The Liturgists App written in Laravel.

## Getting Started

Here are the instructions to getting your development environment up and running.

### Prerequisites

You will need Docker. We recommend that you download the app from [here](https://www.docker.com/community-edition). For a great intro tutorial checkout [this](https://docker-curriculum.com).

Also, before running the app for the first time, copy the .env.example file to a file named .env in the project root.

That's it!

### Running the App

Once you have Docker installed, the git repo cloned, and a .env file you can run the `develop` bash script from your project directory.

```
cd $(PROJECT_ROOT)

# start the docker containers
./develop up -d

# generate a laravel app key
./develop artisan key:generate

# create and seed the database
./develop artisan migrate --seed
```

Then go to [http://localhost:8080](http://localhost:8080) to view the running Laravel app.

## Develop Bash Script

The `develop` script has some nifty shortcuts.

#### Artisan

If the first argument of the `develop` script is `art` or `artisan` then everything will be passed to `php artisan`. For example:

```
./develop art make:model

```

#### Composer

If the first argument of the `develop` script is `composer` then everything will be passed to `php composer.phar`. For example:

```
./develop composer require some/package

```

#### Tests

If the first argument of the `develop` script is `test` then everything will be passed to `phpunit.phar`. There is even an extra super-duper shortcut. If your containers are already running then you can just type `develop t` and it will use the running containers instead of spinning up extra ones. For example:

```
./develop test

# if containers already running
./develop t
```

#### Everything Else

Any other arguments passed to `develop` will get forwarded to the `docker-compose` command. And if you don't provide any arguments it will default to `ps` and just show you which containers are currently running. For example:

```
# spin up containers
./develop up -d

# show running containers
./develop
# or
./develop

# shut down containers
./develop down
```
