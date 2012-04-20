# W4111 - Intro to Databases - Project 2, Team 7

## Members
* Samuel Messing <sbm2158@columbia.edu>
* Benjamin Rapaport <bar2150@columbia.edu>

## Files submitted
* expdat.dmp --- data dump from sql tables
* queries.txt --- 3 interesting queries using new relations

## Oracle Information
* Account name: sbm2158@ADB3

## Description of Object Relational Expansion of Schema

We created a new object type `book_typ`, which refers to a physical book, and 
contains the following attributes:

* ISBN (International Standard Book Number), 
* title, 
* subtitle (possibly empty), 
* list of authors, 
* type of book (novel, textbook, etc.),
* year of printing,
* edition.

The authors list is a `varray(10)` of type `varchar(50)`. We decided on an
array of `varchar(50)` instead of an author object because this data is so
orthogonal to the goals of our database---we do not need information about the
authors for the database to function properly, in fact the ISBN alone is enough
to uniquely identify each book. We record a minimal amount of information to
aid humans in distinguishing books of the same title but different authors. We
decided on an array instead of a string field since different books will have a
different number of authors. By creating the book type, we were able to greatly
simplify the construction of the `Projects_Request` table (see below).  

We added the following covenience methods to our book type:

* `get_authors()`
* `get_year()`
* `get_title()`
* `get_isbn()`
* `get_edition()`

Using this new object type, we created the new relation `Projects_Request`
which records requests for books that can be made by projects.
This relation holds the following attributes:

* primary key of associated project (pid - project id, tid - teacher id)
* a reference to the book being requested
* number of books requested
* date of the request (stored in unix time format, number of seconds since Jan 1, 1970).

 
