/* 
Authors: 
 - Samuel Messing <sbm2158@columbia.edu>
 - Benjamin Rapaport <bar2150@columbia.edu>

 Conventions:
 - Entity table names start with a single capital letter,
   words separated by underscores
 - Relationship table names are all capitals, words separated
   by underscores

 NOTE: there are several integrity constraints mentioned that
 we could not yet caputre (i.e. that the attribute "amount" in
 the entity set Donations be nonnegative).

 NOTE: the size of char attributes is subject to change, the
 current values were our best estimates of our needs.
 NOTE: we could not fully capture the PROPOSE relationship,
 specifically, we could not enforce the total participation
 of teacher entities in the PROPOSE relationship. In order
 to do this, we'll need to use queries that we have yet to
 learn how to implement.
*/


create table Projects_PROPOSE_AT(
  pid integer,
  fundURL varchar2 (200),
  fundingStatus varchar2 (50),
  fulfillmentTrailer varchar2 (1000),
  expirationDate date,
  totalPrice real,
  title varchar2 (100),
  subject varchar2 (100),
  shortDescription varchar2 (500),
  proposalURL varchar2 (100) not null,
  percentFunded real,
  imageURL varchar2 (200),
  numStudents integer,
  tid int not null,
  ncesId varchar2 (50) not null,
  primary key (pid, tid),
  unique (proposalURL),
  constraint fk_Teachers foreign key (tid) references Teachers (tid),
  constraint fk_Schools foreign key (ncesId) references Schools_S_IN_S_HAVE (ncesId),
  check (numStudents >= 0),
  check (percentFunded >= 0 AND percentFunded <= 1),
  check (totalPrice >= 0)
);


create table Teachers(
  tid int,
  name varchar2 (50) not null,
  primary key (tid)
);


create table Users(
  email varchar2 (50),
  displayName varchar2 (50) not null,
  password varchar2 (50) not null,
  passwordSalt varchar2 (50) not null,
  primary key (email),
  check (REGEXP_LIKE (email, '\w+@\w+(\.\w+)+'))
);


create table Donations_FUND(
  tid int not null,
  pid int not null,
  email varchar2 (50) not null,
  amount real not null,
  donationDate date,
  did int,
  primary key (did),
  foreign key (tid, pid) references Projects_PROPOSE_AT(tid, pid),
  foreign key (email) references Users,
  check (amount >= 0)
);

create table Comments_ABOUT(
  tid int not null,
  pid int not null,
  comments varchar2 (500) not null,
  cDate date,
  email varchar2 (50),
  primary key (cDate, email),
  foreign key (email) references Users,
  foreign key (tid, pid) references Projects_PROPOSE_AT(tid, pid)
);


create table VOTE(
  vDate date,
  tid int,
  pid int,
  email varchar2 (50),
  primary key (tid, pid, email),
  foreign key (email) references Users,
  foreign key (tid, pid) references Projects_PROPOSE_AT(tid, pid)
);


create table Schools_S_IN_S_HAVE(
  ncesId varchar2 (50),
  name varchar2 (100),
  avgClassSize real,
  povertyLevel varchar2 (25),
  avgMathSATScore int,
  avgReadingSATScore int,
  avgWritingSATScore int,
  currentGrade char(2),
  progressGrade char(2),
  graduationRate real,
  percentAPAbove2 real,
  dNumber int not null,
  latitude real not null,
  longitude real not null,
  zipcode int not null,
  primary key (ncesId),
  foreign key (dNumber) references Districts_D_IN,
  foreign key (latitude, longitude) references Addresses (latitude, longitude),
  check (avgClassSize is null OR avgClassSize >= 0),
  check (avgMathSATScore is null OR (avgMathSATScore >= 200 AND avgMathSATScore <= 800)),
  check (avgReadingSATScore is null OR (avgReadingSATScore >= 200 AND avgReadingSATScore <= 800)),
  check (avgWritingSATScore is null OR (avgWritingSATScore >= 200 AND avgWritingSATScore <= 800)),
  check (percentAPAbove2 is null OR (percentAPAbove2 >= 0 AND percentAPAbove2 <= 1))
);


create table Addresses(
  latitude real,
  longitude real,
  streetNumber varchar2 (25),
  streetName varchar2 (100),
  zipcode int,
  primary key (latitude, longitude),
  check (latitude >= -90 AND latitude <= 90),
  check (longitude >= -90 AND longitude <= 90),
  check (REGEXP_LIKE (zipcode, '\d{5}'))
);

create table Districts_D_IN(
  avgAttendance real,
  percentRecvPublicAsst real,
  dNumber int,
  bName varchar2 (50) not null,
  primary key (dNumber),
  foreign key (bName) references Boroughs,
  check (percentRecvPublicAsst is null OR (percentRecvPublicAsst >= 0 AND percentRecvPublicAsst <= 1)),
  check (avgAttendance is null OR (avgAttendance >= 0 AND avgAttendance <= 1))
);

create table Boroughs(
  bName varchar2 (50),
  primary key(bName)
);

create table After_School_Programs_A_HAVE(
  aid int,
  name varchar2 (100) not null,
  programType varchar2 (100),
  agencyName varchar2 (100),
  organizationName varchar2 (100),
  elementaryLevel char(1) check (elementaryLevel in ('T', 'F')),
  middleSchoolLevel char(1) check (middleSchoolLevel in ('T', 'F')),
  highSchoolLevel char(1) check (highSchoolLevel in ('T', 'F')),
  organizationPhoneNumber varchar2 (20),
  latitude real not null,
  longitude real not null,
  zipcode int not null,
  primary key (aid),
  foreign key (latitude, longitude) references Addresses (latitude, longitude)
);