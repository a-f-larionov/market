# Тестовое задание
# "Необходимо написать упрощённое REST API."

## Задача

Каркас приложения, должен быть стандартный MVC, реализованный через Controller, Entity, Repository, Service.
API должно содержать 4 метода:
1) Сгенерировать стартовый набор данных, генерируется 20 сущностей "товар", у которых есть идентификатор, название и цена.
2) Метод получения всех существующих товаров.
3) Создать заказ. Метод принимает набор идентификаторов существующих товаров. У заказа есть статус, который может быть в 2 состояниях: новый, оплачено. При создании заказа, по умолчанию выставляется статус "новый". При успешном создании заказа, метод должен возвращать этот номер в ответе на запрос.
4) Оплатить заказ. Метод принимает на вход сумму и идентификатор заказа. Если сумма совпадает с суммой заказа и статус заказа "новый", то отправляем http запрос на сайт ya.ru, если статус запроса 200, то меняем статус заказа на "оплачено".

Таблицу пользователей делать не нужно, считаем, что пользователь всегда авторизирован под id=1, login=admin.
Количество товаров в расчёт не берём, считаем, что их у нас бесконечное количество.
Задачу нужно реализовать без фреймворков, никаких триггеров, процедур в mysql использовать нельзя, только обычные sql запросы и транзакции.
Использовать сторонние отдельные библиотеки можно (например symfony router).
Решение необходимо выложить на github или аналогичный сервис с системой контроля версий.
Проект должен быть оформлен так, как будто выкладываете его в продакшн (никакого закомментированного кода, переменные называем сразу как надо и т.п.).



## Решение

## Ссылки на 4 реализованных метода:

- создание тестовых товаров: [goods/create-test-pack](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/create-test-pack)

- вывести все товары: [goods/list-all](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/list-all)
- вариант с пейджером: [goods/list-all?page=1](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/goods/list-all?page=1)

- создать заказ:  [orders/create?ids=1,2,3](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/orders/create?ids=1,2,3)
- оплатить заказ: [orders/pay/1/123.45](http://market.8ffd246e-5d74-49a5-8696-e92eff606a60.pub.cloud.scaleway.com/orders/pay/1/123.45)



## Описание:

Простой фреймворк с применением шаблонов:
MVC, Singleton, Repository, Entity, Controller, Dependency Injection, Router.

Lifecycle:
- точка входа public/index.php;
- подключается автозагрузчик от композера;
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
- некоторые апи методы сделать POST, т.к GET ограничен ~2048 символами, и это не соотвествует HTTP протоколу;
- пакет php-dotenv и другие базовые вещи фреймворков;
