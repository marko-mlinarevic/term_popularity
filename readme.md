# Term popularity search

This app looks at popularity of specific term in Github issues section

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need to have installed before starting

* [xampp](https://www.apachefriends.org/index.html) - The web framework used
* [composer](https://getcomposer.org/) - Dependency management
* [node.js](https://nodejs.org/) - Javascript server for frontend

### Installing

First you will need to clone/download the project to this url

```
https://github.com/marko-mlinarevic/term_popularity.git
```
into folder
```
C:\xampp\htdocs\undabot\githubIssuesSearch\
```

After that you will need to enter 

```
composer install
```

after that 

```
npm install
```

Then turn on xampp and go to phpmyadmin and make database with name

```
undabot
```

After that we need to map the project in vhost config file in apache 
and system32 drivers config file

vhost config file in apache

```
<VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs\undabot\githubIssuesSearch\public"
    ServerAdmin www.term.undabot
    <Directory "C:\xampp\htdocs\undabot\githubIssuesSearch">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

system32 drivers config file

```
127.0.0.1 www.term.undabot
```

After that copy .env.example and inside change database name
username and password into this

```
DB_DATABASE=undabot
DB_USERNAME=root
DB_PASSWORD=
```

Then go to console again and enter

```
php artisan key:generate 
```
to generate key for the app. After that

```
php artisan migrate
```
then 

```
php artisan passport:install
```
then

```
php artisan passport:client --client
```

Generated token and Id copy to .env file under 

```
CLIENT_ID=some_id
CLIENT_SECRET=generated_token
```

After all that go to 

```
www.term.undabot
```

and try the app

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [Vue](https://vuejs.org/) - Frontend javascript framework
* [Bootstrap-Vue](https://bootstrap-vue.js.org/) - CSS framework


## Authors

* **Marko Mlinarević** - *Initial work* - [Term Popularity](https://github.com/marko-mlinarevic/term_popularity)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details