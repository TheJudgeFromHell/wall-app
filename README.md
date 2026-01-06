# Стена сообщений

Веб-приложение для обмена сообщениями с полной системой регистрации и авторизации пользователей.

## Функциональность

### Для гостей:
- Просмотр всех сообщений на стене
- Регистрация нового аккаунта
- Авторизация в системе

### Для авторизованных пользователей:
- Создание новых сообщений
- Просмотр всех сообщений с именами авторов
- Редактирование своих сообщений (в течение 24 часов)
- Удаление своих сообщений (в течение 24 часов)

## Техноогии
- **Backend:** PHP 7.4+
- **База данных:** MySQL
- **Frontend:** HTML5, CSS3
- **Аутентификация:** Сессии PHP
- **Безопасность:** Защита от SQL-инъекций и XSS-атак

## Структура проекта
wall-app/
├── index.php # Главная страница
├── register.php # Регистрация пользователей
├── login.php # Авторизация
├── logout.php # Выход из системы
├── create_message.php # Создание сообщений
├── edit_message.php # Редактирование сообщений
├── delete_message.php # Удаление сообщений
├── config/
│ └── database.php # Настройки подключения к БД
├── includes/
│ ├── header.php # Общий header для всех страниц
│ ├── footer.php # Общий footer для всех страниц
│ └── functions.php # Вспомогательные функции
├── css/
│ └── style.css # Стили CSS
└── README.md # Документация


## Установка и запуск

### Требования:
- Open Server 
- PHP 7.4+
- MySQL 5.7+

### Шаги установки:
1. Установите Open Server
2. Поместите файлы проекта в `C:\OpenServer\domains\wall-app\`
3. Запустите Open Server
4. Откройте phpMyAdmin: `http://localhost/openserver/phpmyadmin/`
5. Создайте базу данных: `wall_app_db`
6. Выполните SQL-запросы для создания таблиц:

```sql
-- Таблица пользователей
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица сообщений
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
); 
```sql

7. Откройте приложение: http://wall-app/

### Использование

1. Регистрация: Нажмите "Регистрация", заполните форму
2. Авторизация: Войдите с email и паролем
3. Создание сообщения: Нажмите "Новое сообщение"
4. Редактирование: Нажмите "Редактировать" под своим сообщением
5. Удаление: Нажмите "Удалить" под своим сообщением

### Особенности безопасности

- Пароли хранятся в хешированном виде (password_hash)
- Защита от SQL-инъекций через подготовленные выражения
- Защита от XSS через htmlspecialchars()
- Проверка прав доступа для редактирования/удаления
- Ограничение времени редактирования (24 часа)

Автор
[Баландина Дарья]