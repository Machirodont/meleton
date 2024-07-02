install:
	sudo docker-compose down
	sudo docker-compose build
	sudo docker-compose up -d
	sudo docker-compose run --rm meleton_php composer install
	sudo docker-compose run --rm meleton_php php artisan migrate
	sudo docker-compose run --rm meleton_php php artisan app:load-courses
	sudo docker-compose run -d --rm meleton_php php artisan schedule:work

rebuild:
	sudo docker-compose down
	sudo docker-compose build
	sudo docker-compose up -d

chmod:
	sudo chmod -R 777 ./laravel

phpcli:
	sudo docker exec -it meleton_php bash