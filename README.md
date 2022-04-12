<img src="https://yourimageshare.com/ib/hrlhyYfBWr.jpg" alt="License">

## About Email Verification

Laravel comes with builtin elegant solution for email verification which most web applications require so frequently. Setting up a secure email verification system is a breeze in Laravel but by default it only supports stateful requests with standard HTTP redirects. There is a lot of ado if your API based application requires email verification because the builtin solution won't work with that. I have tried to cover the mundane task and give a head start to everyone looking for a solution like this:

## Steps to Rebuild

**_All the commands down below should be run in project's root directory_**
1. Clone the repository by running the following command
```sh
git clone https://github.com/ismail17719/Rhanra.git
```
2. Open the terminal and go to the project root directory
3. Run the composer command to install all dependencies
```sh
composer install
```
4. Open .env.example and save it as .env file in the same root directory
5. Open .env file and change the following database details
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOURDATABASE
DB_USERNAME=USERNAME
DB_PASSWORD=PASSWORD
```

6. Run the following command to generate a unique for the application
```sh
php artisan key:generate
```
7.  Next we need to build the database. In order to do that run the following command in terminal. Let the process complete
```sh
php artisan migrate --seed
```
8. We also need to build the project resources. To do that you should to have Nodejs installed

For signup:
```sh
curl --location --request POST 'http://yourdomain.com/project-directory/public/api/signup' \
--header 'Accept: application/json' \
--form 'name="YOUR NAME"' \
--form 'email="youremail@domain.com"' \
--form 'password="YOUR PASSWORD"' \
--form 'password_confirmation="YOUR PASSWORD"'
```
For login:
```sh
curl --location --request POST 'http://yourdomain.com/project-directory/public/api/login' \
--header 'Accept: application/json' \
--form 'email="youremail@domain.com"' \
--form 'password="YOUR DOMAIN"'
```
9. You should get correct JSON responses for all requests

 :boom: :boom: :boom:
