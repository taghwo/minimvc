# Task MVC Framework

# Requirements
```sh
PHP 7.3 ^
Composer
MYSQL 5.5^
```

# iNSTALLATION
```sh
Clone repository
```
```sh
composer install
```

```sh
 Run composer dump-autoload
 ```

```sh
Create a .env file in the root of of the app, copy and paste .env.example placeholders
Update your app credentials in .env
```

```sh
Modify boom permissions
chmod +x boom
```
```sh
Run migrations for users table with
php ./boom migrate users
```

```sh
start app with
cd public && php -S 127.0.0.1:8000
```

 # Usage
 # endpoints
```sh
Currently all enpoints are in route.php file
```

```sh
During registration and login submitted data will be validated
```

# NOTE
```sh
Authentication is based on session for now
```

```sh
Status code returned include
1: 401 for unauthenticated response
2: 400 for for invalid credentials
3: 500 for for server error
4: 200 for for ok
5: 201 for for created
6: 417 for for unexpected error
```

```sh
Successful request will return json object
```
