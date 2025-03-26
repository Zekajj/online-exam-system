CREATE DATABASE onlineexam;
\c onlineexam; -- Connect to the database

-- Subject Table
CREATE TABLE subject (
    Id SERIAL PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table
CREATE TABLE users (
    Id SERIAL PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    UserType CHAR(1) NOT NULL,
    Email VARCHAR(150) UNIQUE NOT NULL,
    Username VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(100) NOT NULL,
    VerificationCode INT,
    VerificationStatus CHAR(1),
    Status CHAR(1),
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exam Table
CREATE TABLE exam (
    Id SERIAL PRIMARY KEY,
    Subject INT REFERENCES subject(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Title VARCHAR(150) NOT NULL,
    StartDate TIMESTAMP NOT NULL,
    Duration INT NOT NULL,
    Status CHAR(1),
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Questions Table
CREATE TABLE questions (
    Id SERIAL PRIMARY KEY,
    ExamId INT REFERENCES exam(Id) ON DELETE CASCADE,
    Subject INT REFERENCES subject(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Title TEXT NOT NULL,
    Points INT NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Answers Table
CREATE TABLE answers (
    Id SERIAL PRIMARY KEY,
    QuestionId INT REFERENCES questions(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Title TEXT NOT NULL,
    Status CHAR(1),
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Student Exam Table
CREATE TABLE studentexam (
    Id SERIAL PRIMARY KEY,
    ExamId INT REFERENCES exam(Id) ON DELETE CASCADE,
    Subject INT REFERENCES subject(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Student INT REFERENCES users(Id) ON DELETE CASCADE,
    Title TEXT NOT NULL,
    StartTime TIMESTAMP NOT NULL,
    EndTime TIMESTAMP NOT NULL,
    Status CHAR(1),
    ExamStartDate TIMESTAMP NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Student Questions Table
CREATE TABLE studentquestions (
    Id SERIAL PRIMARY KEY,
    QuestionId INT REFERENCES questions(Id) ON DELETE CASCADE,
    StudentExamId INT REFERENCES studentexam(Id) ON DELETE CASCADE,
    ExamId INT REFERENCES exam(Id) ON DELETE CASCADE,
    Subject INT REFERENCES subject(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Title TEXT NOT NULL,
    Points INT NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Student Answers Table
CREATE TABLE studentanswers (
    Id SERIAL PRIMARY KEY,
    StudentQuestionId INT REFERENCES studentquestions(Id) ON DELETE CASCADE,
    QuestionId INT REFERENCES questions(Id) ON DELETE CASCADE,
    AnswerId INT REFERENCES answers(Id) ON DELETE CASCADE,
    Professor INT REFERENCES users(Id) ON DELETE CASCADE,
    Title TEXT NOT NULL,
    Status CHAR(1),
    SelectedAnswer CHAR(1),
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- FAQ Table
CREATE TABLE faq (
    Id SERIAL PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(150) NOT NULL,
    UserId INT REFERENCES users(Id) ON DELETE CASCADE,
    Question TEXT NOT NULL,
    Answer TEXT
);
