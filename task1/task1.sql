-- Имеется база со следующими таблицами:
-- CREATE TABLE `users` (
--     `id`         INT(11) NOT NULL AUTO_INCREMENT,
--     `name`       VARCHAR(255) DEFAULT NULL,
--     `gender`     INT(11) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
--     `birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
--     PRIMARY KEY (`id`)
-- );
-- CREATE TABLE `phone_numbers` (
--     `id`      INT(11) NOT NULL AUTO_INCREMENT,
--     `user_id` INT(11) NOT NULL,
--     `phone`   VARCHAR(255) DEFAULT NULL,
--     PRIMARY KEY (`id`)
-- );
-- Напишите запрос, возвращающий имя и число указанных телефонных номеров девушек в возрасте от 18 до 22 лет.
-- Оптимизируйте таблицы и запрос при необходимости.

SELECT name, COUNT(phone) as count
FROM phone_numbers
JOIN users
ON users.id = phone_numbers.user_id
WHERE users.gender=2
AND TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(users.birth_date), NOW()) BETWEEN 18 AND 22
GROUP BY users.id

-- Можно оптимизировать таблицы:
-- Поле gender сделать ENUM,
-- birth_date преобразовать в дату и изменить тип поля в DATETIME,
-- связать таблицы при помощи FOREIGN KEY на стоблце phone_numbers.user_id