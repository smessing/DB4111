create type author_list as
  varray(10) of varchar(50);
/

create type book_typ as object (
isbn varchar(10),
title  varchar(100),
subtitle varchar(100),
authors author_list,
type varchar(50),
year date,
edition number,
member function get_authors return author_list,
member function get_year return date,
member function get_title return varchar,
map member function get_isbn return varchar,
member function get_edition return number
);
/

create type body book_typ as
  member function get_authors return author_list is
   begin
     return authors;
  end;
  member function get_year return date is
  begin
    return year;
  end;
  member function get_title return varchar is
  begin
    return title;
  end;
  map member function get_isbn return varchar is
  begin
    return isbn;
  end;
  member function get_edition return number is
  begin
    return edition;
  end;
end;
/

-- book table:

create table book_typ_table of book_typ;

-- request table
create table projects_request(
  pid varchar2(32),
  tid varchar2 (32),
  book ref book_typ scope is book_typ_table,
  requestDate int,
  requestQuant int,
  primary key (pid, tid, requestDate),
  constraint projects_request_project_fk foreign key (pid, tid) references Projects_Propose_At (pid, tid)
);