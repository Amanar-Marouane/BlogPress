/*DROP DATABASE IF EXISTS blogpress;
CREATE DATABASE blogpress;
USE blogpress;

CREATE TABLE users(
user_id INT PRIMARY KEY AUTO_INCREMENT,
user_name VARCHAR(20) NOT NULL,
gmail VARCHAR(50),
user_password VARCHAR(72),
creation_date DATETIME
);

CREATE TABLE articles(
article_id INT PRIMARY KEY AUTO_INCREMENT,
author_id INT,
FOREIGN KEY(author_id) REFERENCES users(user_id),
title VARCHAR(50) NOT NULL,
arti_desc TEXT NOT NULL,
created_at DATETIME,
views_number INT NOT NULL,
likes_number INT NOT NULL
);

CREATE TABLE comments(
article_id INT,
FOREIGN KEY(article_id) REFERENCES articles(article_id),
user_id INT,
FOREIGN KEY(user_id) REFERENCES users(user_id),
user_name VARCHAR(20) NOT NULL,
comment_desc VARCHAR(256) NOT NULL,
created_at DATETIME
);*/


SELECT * FROM users;
SELECT * FROM articles;
SELECT * FROM comments;