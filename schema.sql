CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email CHAR(128),
	name CHAR(128),
	password CHAR(64),
	registration_date DATE,
	contacts CHAR
);

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128)
);

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR,
	creation_date DATE,
	done_date DATE,
	deadline_date DATE,
	file CHAR
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX category ON category(name);
CREATE INDEX pass ON users(password);