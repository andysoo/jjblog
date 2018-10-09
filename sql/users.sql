show databases;
drop database if exists jjblog;

show databases;
create database jjblog;
show databases;


use jjblog;
drop table if exists `users`;
create table if not exists `users`(
  `id` int(11) not null auto_increment ,
  `user` varchar(16) not null unique,
  `pass` varchar(36) not null,
  `name` varchar(18) not null unique,
  primary key (`id`) -- unique
)ENGINE=InnoDB default charset=UTF8;

desc users;