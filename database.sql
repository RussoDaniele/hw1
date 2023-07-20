Create DATABASE hm;
USE hm;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    propic varchar(255)
) Engine = InnoDB; 

CREATE TABLE savedmovies(
    id integer primary key auto_increment,
    user integer not null,
    image varchar(255),
    title varchar(255),
    genre varchar(255),
    runtime varchar(255),
    cast varchar(255),
    plot varchar(255)
) Engine = InnoDB;