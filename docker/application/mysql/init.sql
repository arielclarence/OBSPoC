CREATE USER 'boilerplate'@'%' IDENTIFIED BY 'boilerplate';
GRANT ALL PRIVILEGES ON *.* TO 'boilerplate'@'%';
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS boilerplate;
