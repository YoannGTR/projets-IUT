drop schema if exists partie1 cascade;

create schema partie1;

set schema 'partie1';

create table _module(
  id_module       varchar(6)  not null,
  libelle_module  varchar(150) not null,
  ue              char(4)     not null,
  constraint _module_pk primary key(id_module)
);

WbImport -file=./data/ppn.csv
         -header=true
         -delimiter=';'
         -table=_module
         -schema=partie1
         -filecolumns=id_module,ue,libelle_module
;
