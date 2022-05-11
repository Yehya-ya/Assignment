# 

project was built using laravel framework

## Requirements

Php >= 7.3<br>
composesr
npm
git

## setup

1)  Clone the project
```sh
git clone https://github.com/Yehya-ya/Assignment.git
cd Assignment 
```
 
2) intall dependencies
```sh
composer install 
npm install
npm run dev
```

3) Copy .env.example file to .env on the root folder and change the needed configration for the database. 
on windows 
```sh
copy .env.example .env 
```
on linux
```sh
cp .env.example .env
```
for APP_KEY
```sh
php artisan key:generate 
```

4) run the migration with the seeded to fill the database with the test data 
```sh
php artisan migrate:fresh --seed
```
5) run the local server and open http://localhost:8000
```sh
php artisan serve
```
