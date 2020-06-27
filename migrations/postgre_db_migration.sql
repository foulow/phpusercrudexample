-- Database: php

-- DROP DATABASE php;

CREATE DATABASE php
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'English_United States.1252'
    LC_CTYPE = 'English_United States.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Table: php.users

-- DROP TABLE php.users;

CREATE TABLE php.users
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    gender character varying(1) COLLATE pg_catalog."default" NOT NULL,
    color character varying(10) COLLATE pg_catalog."default" NOT NULL,
    hash character varying(100) COLLATE pg_catalog."default" NOT NULL,
    isadmin bit(1) NOT NULL DEFAULT '0'::"bit",
    CONSTRAINT users_pkey PRIMARY KEY (id)
)
TABLESPACE pg_default;

INSERT INTO php.users(name, gender, color, hash, isadmin)
	VALUES (root, 'o', '#0f0', '$2y$10$7LylyImbz7K3yWzT7JTzNO/ziSj.7Fo/TEF1n19qw9eeO54CpjkzW', b'1');