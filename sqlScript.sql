CREATE TABLE students (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20)
);

CREATE TABLE professors (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20)
);

CREATE TABLE auth_table (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    studentId INT,
    professorId INT,
    username VARCHAR(50) NOT NULL UNIQUE, 
    password_hash VARCHAR(255) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
); 

ALTER TABLE auth_table ADD FOREIGN KEY (studentId) REFERENCES students(id);
ALTER TABLE auth_table ADD FOREIGN KEY (professorId) REFERENCES professors(id);
