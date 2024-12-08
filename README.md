## Деплой проекта
1. Проверить необходимое окружение (Все зависимости в composer.json). Для установки всех зависимостей запустить команды:
```composer install```  
```composer update```
2. Подключение к сторонней базе данных не требуется, все работает на дефолтной sqlite базе в дирекории /database
3. Команды для решения возможных проблем с правами на linux:
```
cp .env.example .env
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
sudo chmod -R ugo+rw storage
```
4. Запуск сервера на локальной машине:  
```php artisan serve```
     
Если все сделано правильно на этом этапе laravel должен выдать ошибку "Base table or view not found" и предложение о запуске миграции  
Запуск миграции с сидером:
``` php artisan migrate:fresh --seed```  

## Методы

get api/users - получить список всех пользователей  
get api/users/{id} - получить данные конкретного
пользователя    
post api/users - создать нового пользователя  
put api/users/{id} - обновить данные пользователя  
delete api/users/{id} - удалить пользователя   
