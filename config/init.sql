drop database if exists typrogame_php;

create database typrogame_php;

grant all on typrogame_php.* to dbuser@localhost identified by 'jfa683BjI';

use typrogame_php;

create table users (
  id int not null auto_increment primary key,
  username varchar(255) unique,
  email varchar(255) unique,
  password varchar(255),
  htmlscore float unsigned default 0.0,
  cssscore float unsigned default 0.0,
  jsscore float unsigned default 0.0,
  phpscore float unsigned default 0.0,
  created datetime,
  modified datetime
);

desc users;
select * from users;
