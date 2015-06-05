# Openshift quickstart: Laravel

This is a [Laravel](http://laravel.com/) project that you can use as the starting point to develop your own and deploy it on an [OpenShift](https://github.com/openshift/origin) cluster.

It assumes you have access to an existing OpenShift installation.


## What has been done for you

This is a minimal Laravel project. It was created with these steps:

1. Install PHP-5.5 and mcrypt PHP Extension
2. Install `Composer` dependency manager `php -r "readfile('https://getcomposer.org/installer');" | php`
2. Manually install Laravel with `composer global require "laravel/installer=~1.1"`
3. `laravel new new-app` to create new app
4. Update `config/database.php` for default database to `'default' => 'mysql'`

From this initial state you can:
* create new Laravel apps
* remove the `new-app` app
* rename the Laravel project
* update settings to suit your needs
* install more PHP libraries by adding them to the `composer.json` file


## Local development

To run this project in your development machine, follow these steps:

1. Fork this repo and clone your fork:

    `git clone https://github.com/openshift/laravel-ex.git`

2. Install Apache, PHP-5.5 and mcrypt PHP Extension

3. Install `Composer` dependency manager `php -r "readfile('https://getcomposer.org/installer');" | php`

3. Install dependencies via composer:

    `./composer.phar install --no-interaction --no-ansi --no-scripts --optimize-autoloader`

4. Create a development database:

    `php artisan migrate`

4. If everything is alright, you should be able to start Apache web server to start serving requests:

    `exec httpd -D FOREGROUND`

5. Open your browser and go to http://127.0.0.1:8000, you will be greeted with a welcome page.


## Deploying to OpenShift

To follow the next steps, you need to be logged into an OpenShift cluster and have an OpenShift project where you can work on.


### Using an application template

The directory `openshift/` contains OpenShift application template files that you can add you your OpenShift project with:

    osc create -f openshift/<TEMPLATE_NAME>.json

The template `laravel-source.json` contains just a minimal set of components to get your Laravel application into OpenShift.

The template `laravel-source-postgresql.json` contains all of the components from `laravel-source.json`, plus a MySQL database service and an Image Stream for the PHP base image.

After adding your templates, you can go to your OpenShift web console, browse to your project and click the create button. Create a new app from one of the templates that you have just added.

Adjust the parameter values to suit your configuration. Most times you can just accept the default values, however you will probably want to set the `GIT_REPOSITORY` parameter to point to your fork and the `DATABASE_*` parameters to match your database configuration.

Alternatively, you can use the command line to create your new app:

    osc new-app --template=<TEMPLATE_NAME> --param=GIT_REPOSITORY=...,...

Your application will be built and deployed automatically. If that doesn't happen, you can debug your build:

    osc get builds
    # take build name from the command above
    osc build-logs <build-name>

And you can see information about your deployment too:

    osc describe dc/laravel

In the web console, the overview tab shows you a service, by default called "laravel", that encapsulates all pods running your laravel application. You can access your application by browsing to the service's IP address and port.


### Without an application template

Templates give you full control of each component of your application.
Sometimes your application is simple enough and you don't want to bother with templates. In that case, you can let OpenShift inspect your source code and create the required components automatically for you:

```bash
$ osc new-app openshift/php-55-centos7~https://github.com/openshift/laravel-ex
imageStreams/php-55-centos7
imageStreams/laravel-ex
buildConfigs/laravel-ex
deploymentConfigs/laravel-ex
services/laravel-ex
A build was created - you can run `osc start-build laravel-ex` to start it.
Service "laravel-ex" created at 172.30.16.213 with port mappings 8080.
```

You can access your application by browsing to the service's IP address and port.


## Special files in this repository

Apart from the regular files created by Laravel (`app/*`, `bootstrap/*`, `config/*`), this repository contains:

```
.sti/
└── bin/           - scripts used by source-to-image
    ├── assemble   - executed to produce a Docker image with your code and dependencies during build
    └── run        - executed to start your app during deployment

openshift/         - application templates for OpenShift

.htaccees          - directory-level configuration file for Apache web server

composer.json      - list of dependencies
```


## Data persistence

You can deploy this application without a configured database in your OpenShift project, in which case Django will use a temporary SQLite database that will live inside your application's container, and persist only until you redeploy your application.

After each deploy you get a fresh, empty, SQLite database. That is fine for a first contact with OpenShift and perhaps Django, but sooner or later you will want to persist your data across deployments.

To do that, you should add a properly configured database server or ask your OpenShift administrator to add one for you. Then use `osc env` to update the `DATABASE_*` environment variables in your DeploymentConfig to match your database settings.

Redeploy your application to have your changes applied, and open the welcome page again to make sure your application is successfully connected to the database server.


## Looking for help

If you get stuck at some point, or think that this document needs further details or clarification, you can give feedback and look for help using the channels mentioned in [the OpenShift Origin repo](https://github.com/openshift/origin), or by filling an issue.


## License

This code is dedicated to the public domain to the maximum extent permitted by applicable law, pursuant to [CC0](http://creativecommons.org/publicdomain/zero/1.0/).