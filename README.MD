# Task MVC Framework

# Requirements
```sh
PHP 7.3 ^
Composer
MYSQL 5.5^
```

# INSTALLATION
```sh
Clone repository
https://github.com/taghwo/minimvc.git
```
```sh
Run
composer install
```

```sh
 Run
 composer dump-autoload
 ```

```sh
Create a .env file in the root of of the app, copy and paste .env.example placeholders
Update your app credentials in .env
```

```sh
Modify boom file permissions
Run
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

 # Authentication
```sh
Authentication is handled with bearer tokens
When visiting endpoint that needs authentication pass the access token
that was received during registration or login as bearer in your authorization header.

## Example
Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
```

 # endpoints
```sh
 All npoints reside in route.php file
```

```sh
During registration and login submitted data will be validated
```

```sh
Registration sample payload looks like
{
	"name":"mongoya T",
	"email":"mits@f.com",
	"password":"password"
}

Login sample payload
{
  "email":"mits@f.com",
  "password":"password"
}
```

```sh
Login response payload 
{
  "status": "success",
  "data": {
    "user": {
      "id": "79",
      "name": "mongoya",
      "email": "mit@f.com"
    },
    "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJNVkNBUFAiLCJhdWQiOiJVU0VSIiwiaWF0IjoxNjE3MDQyNDU5LCJuYmYiOjE2MTcwNDI0NjksImV4cCI6MTYxNzA0NjA1OSwiZGF0YSI6eyJpZCI6Ijc5IiwibmFtZSI6Im1vbmdveWEifX0.QzreOSwa6aUe3LAhtwbm7m4BXotez5BqGbWssh6xksI",
    "tokenType": "Bearer"
  }
}
```

```sh
Currently logged in user response payload
{
  "status": "success",
  "data": {
    "id": "79",
    "name": "mongoya",
    "email": "mit@f.com"
  }
}
```

```sh
Status code returned include
1: 401 for unauthenticated response
2: 400 for invalid credentials
3: 500 for server error
4: 200 for ok
5: 201 for created
6: 417 for unexpected error
```