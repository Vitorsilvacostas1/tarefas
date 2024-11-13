create database tarefas;
use tarefas;

create table tbl_usuario (
       id_usu int primary key auto_increment,
       nome_usu varchar(30),
       email_usu varchar(40))
       ;
       
create table tbl_tarefas (
       id_tarefas int primary key auto_increment,
       pendente varchar(40),
       feita varchar(50),
       andamento varchar(60))
       ;
       
alter table tbl_tarefas add column id_usu int,
add constraint fk_tbl_tarefas foreign key (id_usu) references tbl_usuario(id_usu);

select*from tbl_tarefas;


       
       
