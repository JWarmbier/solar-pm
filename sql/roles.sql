CREATE TABLE roles (
        RoleID int NOT NULL AUTO_INCREMENT,
        RoleName varchar(255) NOT NULL,
        PRIMARY KEY (RoleID)
);

INSERT INTO roles(RoleName) VALUES ('Członek');
INSERT INTO roles(RoleName) VALUES ('Lider');
INSERT INTO roles(RoleName) VALUES ('Koordynator');
INSERT INTO roles(RoleName) VALUES ('Inny');

