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
	author CHAR(128) 
);

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR,
	creation_date DATE,
	done_date DATE,
	deadline_date DATE,
	file CHAR,
	author CHAR(128),
	category CHAR(128)
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX category ON category(name);
CREATE INDEX pass ON users(password);
CREATE INDEX c_user ON category(author);
CREATE INDEX t_user ON tasks(author);