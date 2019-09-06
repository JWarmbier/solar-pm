CREATE TABLE departments (
        DepartmentID int NOT NULL AUTO_INCREMENT,
        DepartmentName varchar(255) NOT NULL,
        PRIMARY KEY (DepartmentID)
);

INSERT INTO departments(DepartmentName) VALUES ('Dział Elektryczny');
INSERT INTO departments(DepartmentName) VALUES ('Dział Marketingu');
INSERT INTO departments(DepartmentName) VALUES ('Dział Nadwozia');
INSERT INTO departments(DepartmentName) VALUES ('Dział Podwozia');
INSERT INTO departments(DepartmentName) VALUES ('Inny');

