use jjblog;
drop table if exists `replies`;
create table if not exists `replies`(
  `id` int(11) not null auto_increment,
  `parent_id` int(11) not null ,
  `user_id` varchar(18) not null,
  `content` varchar(255) not null,
  `post_date` TIMESTAMP not null,
  primary key (`id`) -- unique
)ENGINE=InnoDB default charset=UTF8;

desc replies;

insert into `replies` (`parent_id`,`user_id`,`content`,`post_date`) values  
  ('1','andy','回贴内容1','2018-10-07 19:56:01'),
  ('1','andy','回贴内容2','2018-10-07 19:56:02'),
  ('1','andy','回贴内容3','2018-10-07 19:56:03'),
  ('1','andy','回贴内容4','2018-10-07 19:56:04'),
  ('1','andy','回贴内容5','2018-10-07 19:56:05'),
  ('1','andy','回贴内容6','2018-10-07 19:56:06'),
  ('1','andy','回贴内容7','2018-10-07 19:56:07'),
  ('1','andy','回贴内容8','2018-10-07 19:56:08'),
  ('1','andy','回贴内容9','2018-10-07 19:56:09'),
  ('1','andy','回贴内容10','2018-10-07 19:56:10');