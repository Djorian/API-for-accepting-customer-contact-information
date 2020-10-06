CREATE DATABASE IF NOT EXISTS db_12 CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS db_12.clients (
  id int(10) NOT NULL AUTO_INCREMENT,
  source_id int(6) NOT NULL,
  name varchar(50) NOT NULL,
  phone varchar(10) NOT NULL,
  email varchar(100) NOT NULL,
  date int(4) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

INSERT INTO db_12.clients (id, source_id, name, phone, email, date) VALUES
(1, 1, 'Мария', '1564565875', 'maria@email.loc', 6391),
(2, 2, 'Сергей', '6578678596', 'sergey@email.loc', 6391),
(3, 1, 'Владимир', '8785787884', 'vladimir@email.loc', 6392),
(4, 1, 'Елена', '3232321333', 'elena@email.loc', 6393),
(5, 1, 'Игорь', '8546768658', 'igor@email.loc', 6394),
(6, 2, 'Ольга', '4466868662', 'olga@email.loc', 6392),
(7, 2, 'Светлана', '6786746765', 'svetlana@email.loc', 6393),
(8, 1, 'Николай', '5657575775', 'nikolay@email.loc', 6395),
(9, 2, 'Екатерина', '5657567752', 'ekaterina@mail.loc', 6394),
(10, 2, 'Максим', '7777212212', 'maxim@email.loc', 6395);