-- Run this file into a clean/ empty Database

CREATE TABLE roles (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(255),
  CONSTRAINT roles_pk PRIMARY KEY (id)
);

CREATE TABLE users (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  class varchar(10) NOT NULL,
  date_of_birth date,
  role_id integer UNSIGNED,
  CONSTRAINT users_pk PRIMARY KEY (id),
  CONSTRAINT users_role_id_fk FOREIGN KEY (role_id)
  REFERENCES roles (id)
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE educations (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  CONSTRAINT educations_pk PRIMARY KEY (id)
);

CREATE TABLE user_educations (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id integer UNSIGNED NOT NULL,
  education_id integer UNSIGNED NOT NULL,
  CONSTRAINT user_educations_pk PRIMARY KEY (id) ,
  CONSTRAINT user_educations_user_id_fk FOREIGN KEY (user_id)
  REFERENCES users (id)
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT user_educations_education_id_fk FOREIGN KEY (education_id)
  REFERENCES educations (id)
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE courses (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  CONSTRAINT courses_pk PRIMARY KEY (id)
);

CREATE TABLE user_course_grades (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id integer UNSIGNED NOT NULL,
  course_id integer UNSIGNED NOT NULL,
  grade_date date NOT NULL,
  grade integer NOT NULL,
  CONSTRAINT user_course_grades_pk PRIMARY KEY (id),
  CONSTRAINT user_course_grades_user_id_fk FOREIGN KEY (user_id)
  REFERENCES users (id)
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT user_course_grades_course_id_fk FOREIGN KEY (course_id)
  REFERENCES courses (id)
  ON UPDATE NO ACTION ON DELETE NO ACTION
);

INSERT INTO roles VALUES (1, 'Leerling');
INSERT INTO roles VALUES (2, 'Docent');
INSERT INTO roles VALUES (3, 'Directeur');
INSERT INTO roles VALUES (4, 'Ouder');

INSERT INTO users VALUES (1, 'Jan', 'Janssen', 1, '2014-1-22', 1);
INSERT INTO users VALUES (2, 'Piet', 'Pietersen', 1, '2014-2-11', 1);
INSERT INTO users VALUES (3, 'Kees', 'Klaasen', 2, '2014-3-29', 1);
INSERT INTO users VALUES (4, 'Charlie', 'Charlois', 2, '2013-4-12', 1);
INSERT INTO users VALUES (5, 'Suzanne', 'Ans', 3, '2013-5-14', 1);
INSERT INTO users VALUES (6, 'Peter', 'Paters', 3, '2013-6-21', 1);
INSERT INTO users VALUES (7, 'Alex', 'Xerius', 4, '2012-7-20', 1);
INSERT INTO users VALUES (8, 'Marianne', 'Hemels', 4, '2012-8-23', 1);
INSERT INTO users VALUES (9, 'Lily', 'In het Veld', 5, '2012-9-9', 1);
INSERT INTO users VALUES (10, 'Frederique', 'Model', 5, '2011-10-8', 1);
INSERT INTO users VALUES (11, 'Jantje', 'Modaal', 6, '2011-11-2', 1);
INSERT INTO users VALUES (12, 'Pietje', 'Pietersen', 6, '2010-12-5', 1);
INSERT INTO users VALUES (13, 'Keesje', 'Klaasen', 7, '2010-1-7', 1);
INSERT INTO users VALUES (14, 'Charles', 'Charlois', 7, '2009-2-12', 1);
INSERT INTO users VALUES (15, 'Suus', 'Ans', 8, '2009-3-11', 1);
INSERT INTO users VALUES (16, 'Pedro', 'Pedrica', 8, '2008-4-19', 1);
INSERT INTO users VALUES (17, 'Sander', 'Meer', 1, '2014-5-22', 1);
INSERT INTO users VALUES (18, 'Marianne', 'Zee', 2, '2013-6-29', 1);
INSERT INTO users VALUES (19, 'Lilster', 'Augurk', 3, '2012-7-14', 1);
INSERT INTO users VALUES (20, 'Fred ', 'Banaan', 4, '2011-8-18', 1);
INSERT INTO users VALUES (21, 'Karel', 'van Dreumel', 1, '1965-9-12', 2);
INSERT INTO users VALUES (22, 'Karin', 'van Dreumel', 2, '1986-10-24', 2);
INSERT INTO users VALUES (23, 'Theresa', 'de Vries', 3, '1980-11-3', 2);
INSERT INTO users VALUES (24, 'Randy', 'van Beek', 4, '1977-12-1', 2);
INSERT INTO users VALUES (25, 'Riet', 'van Beek-Knoester', 5, '1955-1-6', 2);
INSERT INTO users VALUES (26, 'Brian', 'Edelhert', 6, '1946-2-3', 2);
INSERT INTO users VALUES (27, 'Paula', 'Groen', 7, '1985-3-3', 2);
INSERT INTO users VALUES (28, 'Arie', 'Strauss', 8, '1932-4-3', 2);
INSERT INTO users VALUES (29, 'Felix', 'Bach', 0, '1966-5-3', 3);

INSERT INTO courses VALUES (1, 'Rekenen');
INSERT INTO courses VALUES (2, 'Taal');
INSERT INTO courses VALUES (3, 'Schrijven');
INSERT INTO courses VALUES (4, 'Tekenen');
INSERT INTO courses VALUES (5, 'Gymnastiek');
INSERT INTO courses VALUES (6, 'Handvaardigheid');

INSERT INTO educations VALUES (1, 'PABO');
INSERT INTO educations VALUES (2, 'SPH');
INSERT INTO educations VALUES (3, 'SPW');
INSERT INTO educations VALUES (4, 'Master of School Management');
INSERT INTO educations VALUES (5, 'Geen opleiding');

INSERT INTO user_educations VALUES (1, 29, 4);
INSERT INTO user_educations VALUES (2, 21, 1);
INSERT INTO user_educations VALUES (3, 22, 1);
INSERT INTO user_educations VALUES (4, 23, 1);
INSERT INTO user_educations VALUES (5, 24, 1);
INSERT INTO user_educations VALUES (6, 25, 1);
INSERT INTO user_educations VALUES (7, 26, 1);
INSERT INTO user_educations VALUES (8, 27, 1);
INSERT INTO user_educations VALUES (9, 28, 1);
