# ЕСИА (Госуслуги) PHP/Laravel

Пакет для подключения и работы с ЕСИА.

### Пакет содержит базовый функционал для работы с API

Подключение к ЕСИА происходит путем выполнения требований от разработчиков госуслуг.
Подробнее о подключении вашей системы к ЕСИА читайте тут:
https://partners.gosuslugi.ru/catalog/esia

Данный пакет реализован на методических рекомендациях по использованию ЕСИА
https://digital.gov.ru/uploaded/presentations/metodicheskierekomendatsiipoispolzovaniyuesiav313_VaCOzE9.pdf

### Внимание

Для запросов в ЕСИА потребуется подписывать запрос. Для подписи запросов потребуется сертификат, который должен быть
предварительно зарегестрирован в ЕСИА и привязан у к учетной записи системы-клиента.
ЕСИА использует сертификаты в формате X.509
и взаимодействует с алгоритмами формирования электронной подписи ГОСТ Р 34.10-2012
и криптографического хэширования ГОСТ Р 34.11-2012.

Данная библиотека не может самостоятельно подписывать строки алгоритмами ГОСТ. Для этого нужно реализовать собственный Signer.

На данное время в библиотеке реализованы только несколько персональных методов из api.
Вы сможете получить информацию о пользователе и его документы.

## Установка

```shell
composer require "pavelrockjob/esia"
```

### Laravel (Публикация конфигов)
```shell
php artisan vendor:publish --provider="Pavelrockjob\Esia\Providers\LaravelProvider"
```


## Пример использования библиотеки

index.php
```php
//index.php

require "vendor/autoload.php";

$provider = new \Pavelrockjob\Esia\EsiaProvider(new \Pavelrockjob\Esia\EsiaConfig([
    //Куда отправляем запрос (https://esia-portal1.test.gosuslugi.ru тестовый сервер есиа)
    'esiaUrl' => 'https://esia-portal1.test.gosuslugi.ru',
    //Редирект на страницу после успешной аутентификации
    'redirectUrl' => 'http://127.0.0.1/callback.php',
    //Мнемоника
    'clientId' => 'МНЕМОНИКА_ИЗ_ЕСИА',
    //Доступные скоупы
    'scopes' => [\Pavelrockjob\Esia\Enums\EsiaScope::fullname, \Pavelrockjob\Esia\Enums\EsiaScope::openid]
]),
//Signer, штука которая умеет шифровать строки по алгоритму ГОСТ Р 34.11-2012
//CustomSigner не будет работать, нужно реализовать метот sign
new \Pavelrockjob\Esia\Signers\CustomSigner());

//Получаем ссылку на вход в есиа 
var_dump($provider->getAuthLink());
```

callback.php
```php

$provider = new \Pavelrockjob\Esia\EsiaProvider(new \Pavelrockjob\Esia\EsiaConfig([
    'esiaUrl' => 'https://esia-portal1.test.gosuslugi.ru',
    'redirectUrl' => 'http://127.0.0.1/callback.php',
    'clientId' => 'МНЕМОНИКА_ИЗ_ЕСИА',
    'scopes' => [\Pavelrockjob\Esia\Enums\EsiaScope::fullname, \Pavelrockjob\Esia\Enums\EsiaScope::openid]
]),
new \Pavelrockjob\Esia\Signers\CustomSigner());

//После успешной авторизации можем обращатся к ESIA для получения доступных данных

//Получение OID
$provider->getOid()

//Пример получения персональной информации о пользователе
//Вся доступная информация
$personalData = $provider->api()->prns()->get();
//Конкретное поле
$personalData->getFirstName()

//Персональные документы пользователя
$documents = $provider->api()->prns()->docs();
//Существуют магические методы для получения документов
$provider->api()->prns()->docs()->getRfPassport();
```

### Laravel

EsiaController::index()
```php
//Установите конфиги в config/esia.php
$provider = new EsiaProvider(new EsiaConfig([
            //Установите доступные скоупы
            'scopes' => [
                EsiaScope::openid,
                EsiaScope::fullname,
            ],
        ]), 
        //Signer, штука которая умеет шифровать строки по алгоритму ГОСТ Р 34.11-2012
        //CustomSigner не будет работать, нужно реализовать метот sign
        new \Pavelrockjob\Esia\Signers\CustomSigner());

//Получаем ссылку на вход в есиа 
dd($provider->getAuthLink());
```

EsiaController::callback()
```php

$provider = new EsiaProvider(new EsiaConfig([
            'scopes' => [
                EsiaScope::openid,
                EsiaScope::fullname,
            ],
        ]), 
        new \Pavelrockjob\Esia\Signers\CustomSigner());

//После успешной авторизации можем обращатся к ESIA для получения доступных данных
dd($provider->getOid())
```

Помощь с Signer, пишите в телеграмм @Milenkij 