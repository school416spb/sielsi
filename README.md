# sielsi
Простая электронная подпись PDF документов

1. Загрузите все файлы проекта в корневую директорию сайта
2. Создайте БД mysql и импортируйте в нее таблицу из файла data.sql
3. В файле php/cfg.php задайте настройки подключения к БД
4. Данные пользователя можно править напрямую через БД или через админку по адресу http(s)://сайт/root
5. В качестве логина для входа используется ИНН организации из соответствующего поля в БД, пароль задается произвольным набором символов
6. Для входа в графическом интерфейсе с правами администратора используется по умолчанию логин root, пароль 12345678
7. Логин и пароль можно сменить отредактировав файл /root/index.php
