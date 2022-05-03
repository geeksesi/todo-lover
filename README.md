# todo-lover
todo lover is a laravel package that can manage your todos

[see tasks](https://github.com/geeksesi/todo-lover/blob/master/Task.pdf)

# Installation
```
composer require geeksesi/todo-lover
```

### compatibilities
- php7.4
- laravel 7.x


### enviroments :
- send mail : [mailtrap](https://mailtrap.io/blog/send-email-in-laravel/)


### publish :
```
# migration
php artisan vendor:publish --tag=todo_lover-migrations
# config
php artisan vendor:publish --tag=todo_lover-config
```

# Configs

### Authentication 
default `Authentication model (user)` is set by your app default config on : 
- `config/auth.php` 
```
    // ...

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
    // ...
    
    ],

    // ...
```
this config will overwrite [OwnerModel](https://github.com/geeksesi/todo-lover/blob/ffa8bccd9b84a84ad2cc32e584f5cf1d2544d16e/src/TodoLoverServiceProvider.php#L39) in this package

if there is no providers config we will use our [user model](https://github.com/geeksesi/todo-lover/blob/master/src/Models/User.php) 

to support your user model for `tasks` use this trait :
```
    use \Geeksesi\TodoLover\HasTaskTrait;
```

also if you have your own token authentication ( like passport, sanctum ) you should overwrite config file middelware
```
    "middleware" => ["api", UserHandMadeTokenAuthorize::class],

    # set your authentication middelware instead of : UserHandMadeTokenAuthorize::class
```

# Test
```
composer run test
```

# License 
MIT 