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
arti_img TEXT NOT NULL,
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

/*INSERT INTO users (user_name, gmail, user_password, creation_date)
VALUES
('Alice', 'alice@example.com', 'password123', '2024-12-01 09:00:00'),
('Bob', 'bob@example.com', 'securepass456', '2024-12-02 10:15:00'),
('Charlie', 'charlie@example.com', 'mypassword789', '2024-12-03 11:30:00'),
('Diana', 'diana@example.com', 'strongpass012', '2024-12-04 12:45:00'),
('Eve', 'eve@example.com', 'hunter2', '2024-12-05 14:00:00');


INSERT INTO articles (author_id, title, arti_desc, arti_img, created_at, views_number, likes_number)
VALUES
(1, 'The Art of Coding', 'Exploring the beauty of writing clean and efficient code.', 'https://images.unsplash.com/photo-1734246632356-534e1d1b6b3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2024-12-01 10:30:00', 120, 45),
(2, 'Understanding Databases', 'An article on the fundamentals of relational databases.', 'https://images.unsplash.com/photo-1734246632356-534e1d1b6b3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2024-12-02 15:45:00', 95, 32),
(3, 'Web Development Trends', 'A discussion of the latest web development technologies.', 'https://images.unsplash.com/photo-1734246632356-534e1d1b6b3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2024-12-03 08:20:00', 210, 78),
(4, 'Mastering JavaScript', 'Tips and techniques to become proficient in JavaScript.', 'https://images.unsplash.com/photo-1734246632356-534e1d1b6b3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2024-12-04 14:10:00', 150, 60),
(5, 'The Power of PHP', 'Why PHP remains a strong choice for backend development.', 'https://images.unsplash.com/photo-1734246632356-534e1d1b6b3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2024-12-05 09:00:00', 180, 65);

INSERT INTO comments (article_id, user_id, user_name, comment_desc, created_at)
VALUES
(1, 2, 'Bob', 'Great article on clean coding principles!', '2024-12-01 12:00:00'),
(2, 3, 'Charlie', 'This helped me understand databases better. Thanks!', '2024-12-02 16:30:00'),
(3, 4, 'Diana', 'Interesting trends in web development!', '2024-12-03 09:00:00'),
(4, 5, 'Eve', 'JavaScript is indeed versatile. Great tips!', '2024-12-04 15:00:00'),
(5, 1, 'Alice', 'PHP still has its place in modern development.', '2024-12-05 10:00:00');
*/





SELECT * FROM users;
SELECT * FROM articles;
SELECT * FROM comments;