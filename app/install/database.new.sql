DROP TABLE IF EXISTS config;
CREATE TABLE config(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  option VARCHAR(50) NOT NULL,
  optioningui VARCHAR(50) NOT NULL,
  ispath BOOLEAN NOT NULL DEFAULT 1,
  value VARCHAR(50) NOT NULL,
  editable_via_gui BOOLEAN NOT NULL DEFAULT 1,
  description VARCHAR(200),
  category INT NOT NULL
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  session_id varchar(64) NOT NULL,
  username_id varchar(50) NOT NULL,
  login_time varchar(64) NOT NULL,
  source_ip varchar(15) NOT NULL,
  browser_agent varchar(200) NOT NULL
);