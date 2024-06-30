rebuild:
	sudo docker-compose down
	sudo docker-compose build
	sudo docker-compose up -d

chmod:
	sudo chmod -R 777 ./laravel

phpcli:
	sudo docker exec -it meleton_php bash
