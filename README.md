## Laravel JWT Scaffolding

Laravel (8.x) with JWT with CORS Support out of the box. Just install and start to code your API.

## Get Started

First clone this repo

```
git clone https://github.com/mehadi/laravel-jwt-with-cors-support
```

*Remember to remove .git folder to setup your own git config*


Then enter into the cloned folder and install its dependencies

```
cd your-project-name
composer install 
```

Setup your .env file
```
mv .env.example .env
```

Generate the keys

```
php artisan key:generate
php artisan jwt:secret
```

To finish... just run the migrations

```
php artisan migrate
```

Now you ready to go! 

# Default Routes

|Method    |URI           |Action                   |Middleware    |
|----------|--------------|-------------------------|--------------|
|POST      | api/login    | AuthController@login    | api          |
|POST      | api/logout   | AuthController@logout   | api,auth:api |
|GET       | api/user       | AuthController@user       | api,auth:api |
|POST      | api/refresh  | AuthController@refresh  | api,auth:api |
|POST      | api/register | AuthController@register | api          |

# Protect a Route

You just have to set the middleware to **auth:api**

For example:

```php 
Route::get('/test', function() {
    return 'Test!';
})->middleware('auth:api');
```




