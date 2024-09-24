# ID-Grow Software Engineer Technical Test

## Setup
1. Make sure you already install docker in your host machine
2. Clone this repository
```zsh
https://github.com/devanfer02/id-grow-swe-test.git #https
git@github.com:devanfer02/id-grow-swe-test.git #ssh
```
3. Change directory to the project dir
```zsh
cd id-grow-swe-test
```
4. Clone the ```.env.example``` to ```.env``` file
```zsh
cp .env.example .env
``` 
5. Spin up the containers with this command, the application is running on port :80 so make sure your port :80 is free to use
```zsh
docker compose up -d
```
6. Run the migrations with this command
```zsh
docker exec -it gudang-app php artisan migrate --seed
```
7.Visit the [localhost/api/health](http://localhost/api/health) to check if the container is already running or not

## Database Design

![img](./public/id-swe-test.png)

## Postman Documentation

For API documentation, you can see it from this [link](https://documenter.getpostman.com/view/27789368/2sAXqv5LjS)

## TechStack

[![My Skills](https://skillicons.dev/icons?i=laravel,php,mysql,docker,nginx)](https://skillicons.dev)
