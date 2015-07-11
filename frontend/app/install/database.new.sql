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

DROP TABLE IF EXISTS user;
CREATE TABLE user(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  username varchar(50) NOT NULL,
  password varchar(64) NOT NULL /* for sha256 hash */
);

INSERT INTO config (option, optioningui, ispath, value, description, category) VALUES
  ('mdstat', '/proc mdstat', 1, '/proc/mdstat', "Path to the mdstat file", 3),
  ('sudo', 'subo bin', 1, '/usr/bin/sudo', "Path to the sudo binary", 3),
  ('service', 'service bin', 1, '/usr/sbin/service', "Path to the service binary", 3),
  ('shutdown', 'shutdown bin', 1, '/sbin/shutdown', "Path to the shutdown binary", 3),
  ('idle', 'idle time', 0, 15, 'Time until the user is automatically logged out in minutes', 3);