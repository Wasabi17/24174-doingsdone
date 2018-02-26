CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email CHAR(128),
	name CHAR(128),
	password CHAR(64),
	registration_date DATE,
	contacts TEXT
);

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128),
	user_id INT 
);

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name TEXT,
	creation_date DATE,
	done_date DATE,
	deadline_date DATE,
	file CHAR(128),
	user_id INT,
	category_id INT
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX category ON category(name);
CREATE INDEX pass ON users(password);
CREATE INDEX c_user ON category(user_id);
CREATE INDEX t_user ON tasks(user_id);
CREATE INDEX t_category ON tasks(category_id);
