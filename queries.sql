INSERT INTO users SET email = 'ignat.v@gmail.com', name = 'Игнат', password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', registration_date = '2018.02.26';
INSERT INTO users SET email = 'kitty_93@li.ru', name = 'Леночка', password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', registration_date = '2018.02.26';
INSERT INTO users SET email = 'warrior07@mail.ru', name = 'Руслан', password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', registration_date = '2018.02.26';

INSERT INTO category SET name = 'Входящие', user_id = '1';
INSERT INTO category SET name = 'Учеба', user_id = '1';
INSERT INTO category SET name = 'Работа', user_id = '1';
INSERT INTO category SET name = 'Домашние дела', user_id = '2';
INSERT INTO category SET name = 'Авто', user_id = '3';

INSERT INTO tasks SET name = 'Собеседование в IT-компании', creation_date = '2018.02.10', deadline_date='2018.06.01', file='uploads/Home.psd', user_id = '1', category_id = '3';
INSERT INTO tasks SET name = 'Выполнить тестовое задание', creation_date = '2018.02.11', deadline_date='2018.02.12', user_id = '1', category_id = '3';
INSERT INTO tasks SET name = 'Сделать задание первого раздела', creation_date = '2018.02.14', done_date = '2018.02.15', deadline_date='2018.04.21', user_id = '1', category_id = '2';
INSERT INTO tasks SET name = 'Встреча с другом', creation_date = '2018.02.12', deadline_date='2018.04.22', user_id = '3', category_id = '1';
INSERT INTO tasks SET name = 'Купить корм для кота', creation_date = '2018.02.10', user_id = '2', category_id = '4';
INSERT INTO tasks SET name = 'Заказать пиццу', creation_date = '2018.02.15', file='uploads/Home.psd', user_id = '2', category_id = '4';

/* Получить список из всех проектов для одного пользователя */
SELECT name FROM category WHERE user_id = 1;

/* Получить список из всех задач для одного проекта; */
SELECT * FROM tasks WHERE category_id = 3;

/* Пометить задачу как выполненную */
UPDATE tasks SET done_date = CURDATE() WHERE id = 1;

/* Получить все задачи для завтрашнего дня */
SELECT * FROM tasks WHERE deadline_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY);

/* Обновить название задачи по её идентификатору */
UPDATE tasks SET name = 'Заказать роллы' WHERE id = 6;
