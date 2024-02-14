-- Drop database if it exists; 
DROP SCHEMA IF EXISTS gradebook;

-- Create Database
CREATE DATABASE gradebook;

-- Use Database
USE gradebook;

-- Create tables
CREATE TABLE students (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20), 
    photoUrl VARCHAR(255) DEFAULT 'default.png'
);

CREATE TABLE professors (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    photoUrl VARCHAR(255) DEFAULT 'default.png'
);

CREATE TABLE auth_table (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    studentId INT,
    professorId INT,
    username VARCHAR(50) NOT NULL UNIQUE, 
    password_hash VARCHAR(255) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
); 

CREATE TABLE courses (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    courseId VARCHAR(10) NOT NULL, 
    courseTitle VARCHAR(50) NOT NULL, 
    courseDescription VARCHAR(255) NOT NULL
);

CREATE TABLE grade_categories (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    categoryName VARCHAR(50) NOT NULL, 
    maxObtainable INT NOT NULL
);

CREATE TABLE course_assignments (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    professorId INT NOT NULL,
    courseId INT NOT NULL
);

CREATE TABLE enrollments (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    studentId INT NOT NULL, 
    courseAssignmentId INT NOT NULL
);


CREATE TABLE grade_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    gradeItemName VARCHAR(50) NOT NULL, 
    gradeCategoryId INT NOT NULL, 
    courseAssignmentId INT NOT NULL
);

CREATE TABLE grades (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    enrollmentId INT NOT NULL, 
    gradeItemId INT NOT NULL, 
    score INT NOT NULL DEFAULT 0
);

-- Add foreign key constraints 
ALTER TABLE auth_table ADD FOREIGN KEY (studentId) REFERENCES students(id);
ALTER TABLE auth_table ADD FOREIGN KEY (professorId) REFERENCES professors(id);
ALTER TABLE course_assignments ADD FOREIGN KEY (professorId) REFERENCES professors(id);
ALTER TABLE course_assignments ADD FOREIGN KEY (courseId) REFERENCES courses(id);
ALTER TABLE enrollments ADD FOREIGN KEY (studentId) REFERENCES students(id);
ALTER TABLE enrollments ADD FOREIGN KEY (courseAssignmentId) REFERENCES course_assignments(id);
ALTER TABLE grade_items ADD FOREIGN KEY (gradeCategoryId) REFERENCES grade_categories(id);
ALTER TABLE grade_items ADD FOREIGN KEY (courseAssignmentId) REFERENCES course_assignments(id);
ALTER TABLE grades ADD FOREIGN KEY (enrollmentId) REFERENCES enrollments(id);
ALTER TABLE grades ADD FOREIGN KEY (gradeItemId) REFERENCES grade_items(id);