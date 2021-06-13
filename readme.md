## Установка приложения
В рабочем окружении должен быть установлены docker и docker-compose для установки и запуска приложения.

Для установки и запуска необходимо выполнить следующие шаги:

1. Скачать репозиторий на компьютер с установленым docker-compose

2. запустить команды `make init`
   Данная команда скачает все необходимые образы, соберет и поднимет все коннтйнеры, установит все зависимости vendor и применит миграции
    ```shell script
    make init
    ```

После, на порту `89` должно запуститься приложение.
Для остановки приложения воспользуйтесь командой `make clean`, для его запуска `make init`.

## Уровень покрытия тестами
tests/_output/coverage/index.html

## Спецификация Swagger

Спецификации описываются в директории `./public/swagger`.

Визуальная часть доступна по URL `:89/api/docs`.

## гейтвей
запросы через гейтвей на порт 8402
`localhost:8402/api/v1/users/create`
запросы напрямую в сервис на порт 89
`localhost:89/api/v1/users/create`

## Полезные команды
|   Действие                                |   Команда                 |
|-------------------------------------------|---------------------------|
| Посмотреть что нужно изменить             | `make dist`               |
| Инициализация или переинициализация       | `make init`               |
| Полная остановка приложения и удаление    | `make clean`              |
| Запуск приложения                         | `make start`              |
| Установить все миграции                   | `make migrate`            |
| Остановка приложения                      | `make stop`               |
| Установка зависимостей                    | `make ci`                 |
| Обновление завсимостей                    | `make cu`                 |
| Обновдение автозагрузки                   | `make ca`                 |
| Зайти в контейнер приложения              | `make it`                 |
| Запустить Unit тесты                      | `make run-test`           |
| Запустить Unit тесты с оценкой покрытия   | `make run-test-coverage`  |
| Больше информации о сервисе               | `make info`               |
| фикс кодстайла easy-coding-standard       | `make run-lint`           |
| прогон psalm в сервисе                    | `make run-analyze`        |