create database burgerlab

create table cliente (
    id int auto_increment primary key,
    nome varchar(100),
    email varchar(100),
    senha varchar(255)
)

create table funcionario(
    id int auto_increment primary key,
    nome varchar(100),
    email varchar(100),
    telefone varchar(20),
    número_de_matricula int,
    data_nascimento date
)

create table produtos (
    id int auto_increment primary key,
    nome varchar(100),
    preco decimal(10.2),
    descricao varchar(1000),
    categoria varchar(50),
    imagem varchar(255)
)
