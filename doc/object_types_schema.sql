create type author_varray_type as
  varray(30) of book_type;/

create type book_typ as object(
isbn  varchar(10),
title  varchar(100),
subtitle varchar(100),
authors varchar(50) array[10],
type varchar(50),
year date,
edition number,
map member function get_title return varchar(100),
map member function get_edition return number,
map member function get_atuhors return varchar(50) varray[10],
map member function get_year return date,
map member function get_isbn return varchar(10)
);/

create type author_varray_type as
  varray(30) of book_type;/
