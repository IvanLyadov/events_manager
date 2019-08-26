
INSTALLATION
------------
~~~
git clone https://github.com/JohnLis/events_manager.git
~~~

CONFIGURATION
-------------

### Database
Unzip sql file from `events_manager.zip` and import database into SQL Server.

Change the file name `config/db.php.example` to `config/db.php`.
Edit the file `db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

USING
-------
Login:
~~~
test@test.com
~~~
Password:
~~~
testtest
~~~
