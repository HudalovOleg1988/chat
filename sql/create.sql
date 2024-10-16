CREATE TABLE users (
	userId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	nic VARCHAR(255),
	email VARCHAR(255),
	password VARCHAR(255),
	avatar VARCHAR(255),
	usersdate DATETIME
);

CREATE TABLE user_contact (
	user_id INT,
	contact INT,
	FOREIGN KEY (user_id) REFERENCES users (userId),
	FOREIGN KEY (contact) REFERENCES users (userId)
);

CREATE TABLE chat (
	chatId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user INT,
	contact INT,
	chatdate DATETIME,
	lastupdate DATETIME,
	FOREIGN KEY (user) REFERENCES users (userId),
	FOREIGN KEY (contact) REFERENCES users (userId)
);

CREATE TABLE message (
	textId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	message LONGTEXT,
	messagetime DATETIME,
	view INT,
	user_id INT,
	FOREIGN KEY (user_id) REFERENCES users (userId)
);

CREATE TABLE chat_message (
	chat_id INT,
	messsage_id INT,
	FOREIGN KEY (chat_id) REFERENCES chat (chatId),
	FOREIGN KEY (messsage_id) REFERENCES message (textId)
);

-- 

-- CREATE TABLE users (
-- 	userId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- 	name VARCHAR(255),
-- 	nic VARCHAR(255),
-- 	email VARCHAR(255),
-- 	password VARCHAR(255),
-- 	avatar VARCHAR(255),
-- 	usersdate DATETIME
-- );

-- CREATE TABLE chat (
-- 	chatId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- 	chatdate DATETIME,
-- 	lastupdate DATETIME
-- );

-- CREATE TABLE user_chat (
-- 	user_id INT,
-- 	chat_id INT,
-- 	FOREIGN KEY (user_id) REFERENCES users (userId),
-- 	FOREIGN KEY (chat_id) REFERENCES chat (chatId)
-- );

-- CREATE TABLE message (
-- 	textId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
-- 	message LONGTEXT,
-- 	messagetime DATETIME,
-- 	view INT,
-- 	user_id INT,
-- 	chat_id INT,
-- 	FOREIGN KEY (user_id) REFERENCES users (userId),
-- 	FOREIGN KEY (chat_id) REFERENCES chat (chatId)
-- );

-- CREATE TABLE user_contact (
-- 	user_id INT,
-- 	contact INT,
-- 	FOREIGN KEY (user_id) REFERENCES users (userId),
-- 	FOREIGN KEY (contact) REFERENCES users (userId)
-- );