INSERT INTO users(email,name,password,registration_date,contacts) 
VALUES
('ignat.v@gmail.com','Игнат','$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka','2018.02.26',null),
('kitty_93@li.ru','Леночка','$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa','2018.02.26',null),
('warrior07@mail.ru','Руслан','$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW','2018.02.26',null);

INSERT INTO category(name,user_id)
VALUES
('Входящие',1),
('Учеба',1),
('Работа',1),
('Домашние дела',2),
('Авто',3);

INSERT INTO tasks(name,creation_date,done_date,deadline_date,file,user_id,category_id)
VALUES
('Собеседование в IT-компании','2018.02.10',null,'2018.06.01','uploads/Home.psd',1,3),
('Выполнить тестовое задание','2018.02.11',null,'2018.02.12',null,1,3),
('Сделать задание первого раздела','2018.02.14','2018.02.15','2018.04.21',null,1,2),
('Встреча с другом','2018.02.12',null,'2018.04.22',null,3,1),
('Купить корм для кота','2018.02.10',null,null,null,2,4),
('Заказать пиццу','2018.02.15',null,null,'uploads/Home.psd',2,4);

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