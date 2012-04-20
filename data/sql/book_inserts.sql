insert into book_typ_table values (
  book_typ ('0131103628', 'C Programming Language', '', 
    author_list('kernighan', 'ritchie'), 'text book',
    TO_DATE('1988', 'YYYY'), 2)
);

insert into book_typ_table values (
  book_typ ('0262033844', 'Introduction to Algorithms', '', 
    author_list('cormen', 'leiserson', 'rivest', 'stein'), 'text book',
    TO_DATE('2009', 'YYYY'), 3)
);

insert into book_typ_table values (
  book_typ ('0439708184', 'Harry Potter I', '', 
    author_list('rowling'), 'novel',
    TO_DATE('1999', 'YYYY'), 1)
);

insert into book_typ_table values (
  book_typ ('0439064872', 'Harry Potter II', '', 
    author_list('rowling'), 'novel',
    TO_DATE('2000', 'YYYY'), 1)
);