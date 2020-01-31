Управление проектом
=====================

* Клонировать репозиторий к себе на сервер
```
git clone https://github.com/MargoJoy/bookList.git
```

* Подтянуть зависимости
```
composer install
```

* Создать базу данных 
```
php bin/console doctrine:database:create
```


* Запустить миграции
```
php bin/console doctrine:migrations:migrate
```


***P.S.***

##### Если линукс нужно: 
* Cоставить конфиг nginx
* При создании базы и запуске миграции начинать запрос с ```bin/console ...```


