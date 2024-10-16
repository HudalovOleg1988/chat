INSERT INTO users SET 
name = 'oleg hudalov',
nic = 'o.hudalov',
email = 'hudalov.oleg@mail.ru',
password = '123456',
avatar = 'ucivnopibohuyv',
usersdate = now()

INSERT INTO users SET 
name = 'brad pitt',
nic = 'b.pitt',
email = 'brad_pit@gmail.ru',
password = '123',
avatar = 'ucivnopibohuyv',
usersdate = now()

INSERT INTO users SET 
name = 'tom cruise',
nic = 't.cruise',
email = 't.cruise@yandex.ru',
password = '123',
avatar = 'ucivnopibohuyv',
usersdate = now()

INSERT INTO chat SET 
lastupdate = now(),
chatdate = now()

INSERT INTO user_chat SET 
user_id = 1,
chat_id = 1;

INSERT INTO user_chat SET 
user_id = 2,
chat_id = 1;

INSERT INTO message SET 
message = 'Привет. Как дела?',
messagetime = now(),
view = 1,
user_id = 1,
chat_id = 1;

UPDATE chat SET lastupdate = now() WHERE chatId = 1;

INSERT INTO message SET 
message = 'Привет Олег. Да вроде нормально. Скоро съемки нового фильма',
messagetime = now(),
view = 1,
user_id = 2,
chat_id = 1;

UPDATE chat SET lastupdate = now() WHERE chatId = 1;

INSERT INTO message SET 
message = 'О, классно. А о чём будет фильм?',
messagetime = now(),
view = 1,
user_id = 1,
chat_id = 1;

UPDATE chat SET lastupdate = now() WHERE chatId = 1;

INSERT INTO user_chat SET 
user_id = 1,
chat_id = 2;

INSERT INTO user_chat SET 
user_id = 3,
chat_id = 2;

INSERT INTO message SET 
message = 'Добрый вечер Олег. Не хочешь сняться в новой части Миссия не выполнима?',
messagetime = now(),
view = 1,
user_id = 3,
chat_id = 2;

UPDATE chat SET lastupdate = now() WHERE chatId = 2;

INSERT INTO message SET 
message = 'Привет Том. Я подумаю',
messagetime = now(),
view = 1,
user_id = 1,
chat_id = 2;

UPDATE chat SET lastupdate = now() WHERE chatId = 2;

INSERT INTO message SET 
message = 'Ну подумай конечно, но помни,такая возможность выпадает один раз в жызни',
messagetime = now(),
view = 1,
user_id = 3,
chat_id = 2;

UPDATE chat SET lastupdate = now() WHERE chatId = 2;




























