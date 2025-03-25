    create database onlineexam;
    use onlineexam;

    create table subject(
        Id int auto_increment,
        Name varchar(100),
        Created_at datetime,
        primary key(Id)
    );
    create table users(
        Id int auto_increment,
        FirstName varchar(50),
        LastName varchar(50),
        UserType char(1),
        Email varchar(150),
        Username varchar(100),
        Password varchar(100),
        VerificationCode int,
        VerificationStatus char(1),
        Status char(1),
        Created_at datetime,
        primary key(Id)
    );


    create table exam(
        Id int auto_increment,
        Subject int,
        Professor int,
        Title varchar(150),
        StartDate datetime,
        Duration int,
        Status char(1),
        Created_at datetime,
        primary key(Id),
        foreign key (Subject) references subject(Id),
        foreign key (Professor) references users(Id)
    );

    create table questions(
        Id int auto_increment,
        ExamId int,
        Subject int,
        Professor int,
        Title varchar(20000),
        Points int,
        Created_at datetime,
        primary key(Id),
        foreign key (ExamId) references exam(Id),
        foreign key (Subject) references subject(Id),
        foreign key (Professor) references users(Id)
    );

    create table answers(
        Id int auto_increment,
        QuestionId int,
        Professor int,
        Title varchar(20000),
        Status char(1),
        Created_at datetime,
        primary key(Id),
        foreign key(QuestionId) references questions(Id),
        foreign key (Professor) references users(Id)
    );

    create table studentexam(
        Id int auto_increment,
        ExamId int,
        Subject int,
        Professor int,
        Student int,
        Title varchar(20000),
        StartTime datetime,
        EndTime datetime,
        Status char(1),
        ExamStartDate datetime,
        Created_at datetime,
        primary key(Id),
        foreign key (Student) references users(Id)
    );

    create table studentquestions(	
        Id int auto_increment,
        QuestionId int,
        StudentExamId int,
        ExamId int,
        Subject int,
        Professor int,
        Title varchar(20000),
        Points int,
        Created_at datetime,
        primary key(Id)
    );

    create table studentanswers(
        Id int auto_increment,
        StudentQuestionId int,
        QuestionId int,
        AnswerId int,
        Professor int,
        Title varchar(20000),
        Status char(1),
        SelectedAnswer char(1),
        Created_at datetime,
        primary key(Id)
    );

    create table faq(
        Id int auto_increment,
        FirstName varchar(50),
        LastName varchar(50),
        Email varchar(150),
        UserId int,
        Question varchar(20000),
        Answer varchar(20000),
        primary key(Id),
        foreign key(UserId) references users(Id)
    );