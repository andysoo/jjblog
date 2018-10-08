use jjblog;
drop table if exists `posts`;
create table if not exists `posts`(
  `parent_id` int(11) not null auto_increment,
  `user_id` varchar(18) not null,
  `title` varchar(255)  not null,
  `content` varchar(255) not null,
  `post_date` TIMESTAMP not null,
  `readed` int(255) not null  DEFAULT '0',
  primary key (`parent_id`) -- unique
)ENGINE=InnoDB default charset=UTF8;

desc posts;

insert into `posts` (`user_id`,`title`,`content`,`post_date`) values  
  ('andy','发贴标题1','发贴内容1','2018-10-07 19:56:01'),
  ('andy','发贴标题2','发贴内容2','2018-10-07 19:56:02'),
  ('andy','发贴标题3','发贴内容3','2018-10-07 19:56:03'),
  ('andy','发贴标题4','发贴内容4','2018-10-07 19:56:04'),
  ('andy','发贴标题5','发贴内容5','2018-10-07 19:56:05'),
  ('andy','发贴标题6','发贴内容6','2018-10-07 19:56:06'),
  ('andy','发贴标题7','发贴内容7','2018-10-07 19:56:07'),
  ('andy','发贴标题8','发贴内容8','2018-10-07 19:56:08'),
  ('andy','发贴标题9','发贴内容9','2018-10-07 19:56:09'),
  ('andy','发贴标题10','发贴内容10','2018-10-07 19:56:10');
        