# market-test-1

Тестовое задание: Необходимо написать упрощённое REST API.

Ссылки на 4 метода:

- создание тестовых товаров: [goods/create-test-pack](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/create-test-pack)

- вывести все товары: [goods/list-all](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/list-all)
- вариант с пейджером: [goods/list-all?page=1](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/list-all?page=1)

- создать заказ:  [orders/create?ids=1,2,3](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/orders/create?ids=1,2,3)
- оплатить заказ: [orders/pay/1/123.45](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/orders/pay/1/123.45)



Описание :

Простой фреймворк с применением шаблонов:
MVC, Singleton, Repository, Entity, Controller, Dependency Injection, Router.

Lifecycle:
- точка входа public/index.php;
- подключается автозагрузчик композера;
- определяется функцию config(), предоставляющая доступ к конфигурационному файлу config.php;
- определяется функцию app(), предоставляющая доступ к копонентам, например app()->get('compnentName');
- загружается компоненты указанные в config.php ['components'];
- выполняется обработка запроса;


Что нужно было бы сделать, если это не тестовое задание:
- использовать валидатор, факт: проверяем нативно;
- создать менеджер заказов как компонент, факт: заказ содается в контроллере заказов;
- использовать какой нибудь пакет для работы с конфигурацией, факт: простая функция config();
- профилирование запросов, факт: при создании заказа одна позиция - один запрос;
- кэшировать или хранить в БД цену заказа, факт: цена заказа считается каждый раз заново;
- некоторые апи методы сделать POST, т.к GET ограничен ~2048 символами, и это не соотвествует HTTP протоколу.
- пакет php-dotenv и другие базовые вещи фреймворков;
