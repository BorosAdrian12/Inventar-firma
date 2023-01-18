use a_boros;
-- create table users(
-- idUser int not null auto_increment,
-- username varchar(32) not null,
-- email varchar(64) not null,
-- password varchar(256) not null ,
-- token varchar(256) ,
-- tokenLife timestamp DEFAULT CURRENT_TIMESTAMP not null,
-- primary key(idUser)
-- );
-- create table address(
-- id int not null auto_increment,
-- address_location varchar(64) not null,
-- primary key(id)
-- );
-- create table deposit(
-- id int not null auto_increment,
-- address_id int not null ,
-- name varchar(64) not null,
-- count int not null default 0,
-- primary key(id),
-- foreign key(address_id) references address(id)  
-- );
-- create table productLocation(
-- id int not null auto_increment,
-- user_id int ,
-- deposit_id int ,
-- primary key(id),
-- foreign key(user_id) references users(idUser),
-- foreign key(deposit_id) references deposit(id)
-- );
-- create table item_type(
-- id int not null auto_increment ,
-- name varchar(64) not null,
-- primary key(id)
-- );

-- create table item(
-- id int not null auto_increment,
-- series varchar(64) not null , 
-- name varchar(64) not null , 
-- item_type_id int not null,
-- location_id int not null,
-- primary key(id),
-- foreign key(item_type_id) references item_type(id),
-- foreign key(location_id) references productLocation(id)
-- );
-- NU INTELEG DE CE AM ID_PRODUCT IN PRODUClOCATION

-- ALTER TABLE deposit
-- modify count int not null default 0;

-- insert into address(address_location) values("str. nicolae balacescu nr. 21");
-- select * from deposit;
-- insert into deposit(name,address_id) values("camara 1",1);
-- SELECT id, address_id, name, count FROM deposit;
-- create view deposit_view as 
-- select d.id , l.address_location , d.name , d.count 
-- from deposit as d left join address as l on d.address_id = l.id; 

-- create view productFromDeposit_view as
-- insert into productLocation();

-- desc productLocation;
-- desc item;
-- desc productLocation;
-- alter table productLocation
-- modify id_product int;
-- desc item;
-- select * from productLocation;
select * from deposit;
-- insert into productLocation(deposit_id) values(2);
-- insert into item(series,name,item_type_id,location_id) values('as3gh1n3@#FEEW3fw','apple macbook pro',1,1);
-- insert into item(series,name,item_type_id,location_id) values('d1323r23r243r24ry','apple macbook pro 13',1,1);
-- insert into item(series,name,item_type_id,location_id) values('24msdiewrsdfEWRdh','apple macbook pro 16',1,1);
-- insert into item(series,name,item_type_id,location_id) values('1327824hsdff42f42','laptop lenovo',1,2);
-- insert into item(series,name,item_type_id,location_id) values('131ndsfy24br2n243','tastatura logitech mx key',4,2);
-- select * from item ;
-- select * from users ;
-- alter view getItemsFromDepozit_view as
--  select 
-- 	i.id , i.name , i.series , d.id as id_deposit
--  from item i
-- 	inner join productLocation pl on i.location_id=pl.id
--     inner join deposit d on pl.deposit_id = d.id ;
-- select * from getItemsFromDepozit_view where id_deposit=1;
-- create view returnItemWithLocation_view as 
-- select
-- 	i.id,i.series,i.name,d.name as location,pl.id as idDep
-- from
-- 	productLocation as pl 
--     join deposit as d on pl.deposit_id = d.id
--     join item as i on i.location_id = pl.id;
-- from item i join deposit l 
-- select * from returnItemWithLocation_view where idDep=1;

-- -- alter view returnItemWithLocation_view as 
-- select
-- 	i.id,i.series,i.name,t.name as data,pl.id as idDep
-- from
-- 	productLocation as pl 
--     join deposit as d on pl.deposit_id = d.id
--     join item as i on i.location_id = pl.id
--     join item_type as t on i.item_type_id=t.id;
--     
-- create view returnItemWithType_view as
-- select 
-- 	i.id,i.series,i.name,d.name as data , t.id as idType
-- from
-- 	productLocation as pl 
--     join deposit as d on pl.deposit_id = d.id
--     join item as i on i.location_id = pl.id
--     join item_type as t on i.item_type_id=t.id;

-- select * from returnitemWithType where idType=4;
-- select * from item;
-- select * from users;
-- -- scoate id_product
-- -- alter productLocation
-- select * from productLocation;
-- create table pl_test like productLocation;
-- select * from Test_produs;
-- select id from productLocation where deposit_id = 1;
-- select count(location_id) from item where location_id=1;

-- select id from productLocation where deposit_id is not null;
--  alter view returnItemWithTypeBaseUser_view as
-- select 
-- 	i.id,i.series,i.name,d.username as data , t.id as idType
-- from
-- 	productLocation as pl 
--     join users as d on pl.user_id = d.idUser
--     join item as i on i.location_id = pl.id
--     join item_type as t on i.item_type_id=t.id;
-- select * from returnItemWithTypeBaseUser_view;
-- select count(id) from item where location_id =1;
-- insert into deposit(address_id,name) values(2,"debaraua jos");
-- select * from item_type;
-- SELECT id, name, count FROM item_type limit 10 offset 10;
-- create table log(
-- id int auto_increment primary key,
-- whoDidIt varchar(32) not null default 'necunoscut',
-- action varchar(256) not null,
-- data text,
-- timeAction timestamp DEFAULT CURRENT_TIMESTAMP not null 
-- );
-- insert into log(whoDidIt,action,data) values("marian",'delete ceva','null');
-- select * from users;

-- drop table log;
alter view querySearch_view as
select * from returnItemWithTypeBaseUser_view
union
select * from returnItemWithType_view order by id asc;
select * from log;
select * from querySearch_view ; 
select * from item;
select * from item_type;
select * from productLocation;
select id from productLocation ;
create view returnfulldataItem_view as 
select q.id,q.series,q.name,data as place,t.name as type
from querySearch_view as q join item_type as t on idType=t.id;
select * from returnfulldataItem_view;
select * from deposit where name like '%2%';
-- create view depositWithAddress as 
-- select d.id,d.name,d.count
desc deposit_view;
alter view depositSearch_view as 
select d.id , l.address_location as data , d.name , d.count 
from deposit as d left join address as l on d.address_id = l.id; 
select * from depositSearch_view;