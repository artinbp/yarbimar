<p align="center"><a href="https://laravel.com" target="_blank"><img src="logo.png" width="400" alt="Laravel Logo"></a></p>



# yarbimar
an website to help people to find him medical tools
# installation
first write env config file
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:8NVRZDxFw/HRxKJLHBlzweiJAley6SCNWjrlKzn+KRk=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

```
then run 
```shell
$ php artisan migrade:fresh
```
finally start server serve
```shell
$ php artisan serve
```

# api Auth Routes
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication register
###post [/api/v1/auth/v1/auth/register](http://localhost:8000/api/v1/auth/register).
body
```
{}
```
##authantication user information
###get [/api/v1/auth/user](http://localhost:8000/api/v1/auth/user).
body
```
{}
```

##authantication logout
###post [/api/v1/auth/logout](http://localhost:8000/api/v1/auth/logout).

# api list Dashboard Routes
##dashboard roles
###get [/api/v1/dashboard/roles](http://localhost:8000/api/v1/dashboard/roles).
body
```
{}
```
##list dashboard users
###get [/api/v1/dashboard/users](http://localhost:8000/api/v1/dashboard/users).
body
```
{}
```
##read dashboard users
###get [/api/v1/dashboard/users/1"](http://localhost:8000/api/v1/dashboard/users/1).
body
```
{}
```
##append dashboard users
###post [/api/v1/dashboard/users](http://localhost:8000/api/v1/dashboard/users).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
##authantication login
###post [/api/v1/auth/login](http://localhost:8000/api/v1/auth/login).
body
```
{}
```
