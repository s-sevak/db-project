# База данных

DB_SOURCE=json  # Используйются данные из user.json

DB_SOURCE=mysql # Используйются данные из БД

### Команды CLI

php public/index.php add - добавить пользователя

php public/index.php list - показать пользователей

php public/index.php delete id - удалить пользовател с заданным id

### Команды fpm-fcgi

GET http://localhost:8080/list-users  - показать пользователей

POST http://localhost:8080/create-user - добавить пользователя

{
"firstName": "Имя",
"lastName": "Фамилия",
"email": "firstName@lastName.com"
}

DELETE http://localhost:8080/delete-user/{id} - удалить пользователя
