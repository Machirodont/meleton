Задание 1
---
```mysql
select
    u.id as Id,
    CONCAT(u.first_name, ' ', u.last_name) as Name,
    b.author as Author,
    GROUP_CONCAT(b.name SEPARATOR ',') as Books
from book_users u
left join user_books ub ON u.id=ub.user_id
left join db.books b on b.id = ub.book_id
where u.birthday BETWEEN DATE_SUB(NOW(), INTERVAL 7 YEAR ) and DATE_SUB(NOW(), INTERVAL 17 YEAR )
and datediff(ub.return_date, ub.get_date) <= 14
group by b.author, Id
having COUNT(*)=2;
```

Задание 2
---

Развертывание и запуск
---
  - Окружение, на котором проверялось: Ubuntu 22.04, docker v27.0, docker-compose v1.29
  - В папке проекта выполнить: ```git clone https://github.com/Machirodont/meleton .```
  - Порт 8080 должен быть свободен
  - Скопировать ./laravel/.env.exapmle в ./laravel/.env 
```cp ./laravel/.env.example ./laravel/.env```
  - Запустить команду ```make install``` (на Linux, понадобится пароль для sudo) или соответствущую последовательность команд из Makefile (Windows/Mac)

Тестирование
---
  - Коллекция для Postman: ./Meleton.postman_collection.json
  - Во всех запросах должен передаваться Bearer token ```Authorization: Bearer azAZ09-_``` (в соответствие с требованиями токен один, задан в .env AUTH_TOKEN)
  - Метод rates - GET: http://localhost:8080/api/v1?method=rates
  - Метод convert - POST: http://localhost:8080/api/v1?method=rates

Замечания по реализации
---
  - Деньги считаются во float с округлением до оговоренных значений. Decimal арифметику затягивать не стал, это уже перебор для тестового.
  - Авторизация через единственный статичный токен явно небезопасна, но так в задании
  - Данные о курсах загружаются через Scheduler независимо от пользовательских запросов 
раз в минуту и кэшируются. Курсы для пользовательских запросов берутся из кэша. 
Это позволяет не заспамить сторонний сервис (где данные все равно обновляются раз в 15 минут) и ускорить пользовательские запросы.
