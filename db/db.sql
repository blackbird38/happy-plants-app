sudo mysql -u root


CREATE USER 'blackbird'@'localhost' IDENTIFIED BY 'blackbird';
GRANT all privileges on *.* to 'blackbird'@'localhost';
FLUSH PRIVILEGES;


>exit