create database if not exists ResourceManager;
use ResourceManager;

create table if not exists ClientApplicartion (
    id integer primary key auto_increment,
    devKey integer not null
) default charset=utf8;

create table if not exists AccessRights (
    id integer primary key auto_increment,
    resourceID integer not null,
    clientApplicartionID integer not null,
    clientRight integer not null
) default charset=utf8;

create table if not exists Resource (
    id integer primary key auto_increment,
    type integer
) default charset=utf8;

create table if not exists ResourceMetaData (
    id integer primary key auto_increment,
    resourceID integer,
    dataKey varchar(256),
    value TEXT
) default charset=utf8;

create table if not exists ResourceObject (
    id integer primary key auto_increment,
    resourceID integer,
    textID integer
) default charset=utf8;

create table if not exists TextObject (
    id integer primary key auto_increment,
    textValue TEXT
) default charset=utf8;

create table if not exists ResourceObjectMetaData (
    id integer primary key auto_increment,
    resourceObjectID integer,
    dataKey varchar(256),
    value TEXT
) default charset=utf8;
