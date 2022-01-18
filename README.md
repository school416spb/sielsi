# sielsi
Простая электронная подпись PDF документов
davydov@school416spb.ru версия 2.22.1.18

1. Распакуйте каталог library.zip в корень проекта, архив после этого можно удалить
2. Загрузите все файлы проекта в корневую директорию сайта (кроме файла data.sql)
3. Создайте БД mysql (имя БД сожет быть любым, кодировка utf8_general_ci) и импортируйте в нее таблицу из файла data.sql
4. В файле php/cfg.php задайте настройки подключения к БД, указав имя базы, имя пользователя и пароль
5. Данные пользователя можно править напрямую через БД или через админку по адресу http(s)://сайт/root (по умолчанию есть один рандомный пользователь, которого можно либо отредактировать под себя, либо удалить; ИНН: 0123456789, пароль: 12345678)
6. В качестве логина для входа используется ИНН организации из соответствующего поля в БД, пароль задается произвольным набором символов
7. Для входа в графическом интерфейсе с правами администратора используется по умолчанию логин root, пароль 12345678
8. Логин и пароль администратора можно сменить отредактировав файл /root/index.php
-----
P.S. При локальном размещении файлов в директории html необходимо дать права на исполнение. Петейти в директорию /var/www и выполнить команду sudo chmod 777 -R html/
P.S. Почта администратора системы хранится в текстовом файле mail.php в каталоге templates
