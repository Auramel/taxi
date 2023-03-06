## Команды

----

#### IDE Хелперы
**PHPDoc generation for Laravel Facades**
```
php artisan ide-helper:generate
```

**PHPDocs for models**
```
php artisan ide-helper:models --write-mixin
```

**PhpStorm Meta file**
```
php artisan ide-helper:meta
```

#### Удаление кеша
```
php artisan optimize:clear
```

#### Сборка на проде
```
composer install --no-dev
php artisan migrate
yarn install
yarn run mix --production
php artisan optimize:clear
sudo supervisorctl restart all
sudo reboot
```

#### Запуск теста
```
php artisan test
```
