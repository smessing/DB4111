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
  constraint fk_Teachers foreign key (tid) references Teachers (tid) 
                      on delete no action 
  constraint fk_Schools foreign key (ncesId) references Schools (ncesId)
                      on delete no action
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
  check (REGEXP_LIKE (email, '\w+@\w+(\.\w+)+') > 0)
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
  comment varchar2 (500) not null,
  cDate date,
  email varchar2 (50),
  primary key (cDate, email),
  foreign key (email) references Users
                        on delete no action
                        on update cascade,
  foreign key (tid, pid) references Projects_PROPOSE_AT(tid, pid)
                        on delete cascade
                        on update cascade
);

create table VOTE(
  vDate date,
  tid int,
  pid int,
  email varchar2 (50),
  primary key (tid, pid, email),
  foreign key (email) references Users
                      on delete no action
                      on update cascade,
  foreign key (tid, pid) references Projects_PROPOSE_AT(tid, pid)
                      on delete cascade
                      on update cascade
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
  latitude varchar2 (50) not null,
  longitude varchar2 (50) not null,
  zipcode int not null,
  primary key (ncesId),
  foreign key (dNumber) references School_Districts_D_IN
                          on delete no action
                          on update cascade,
  foreign key (latitude, longitude) references Addresses (latitude, longitude)
                          on delete no action
                          on update cascade,
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
  check (REGEXP_LIKE (zipcode, '/d{5}') > 0)
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
  elementaryLevel boolean,
  middleSchoolLevel boolean,
  highSchoolLevel boolean,
  organizationPhoneNumber varchar2 (20),
  latitude varchar2 (50) not null,
  longitude varchar2 (50) not null,
  zipcode int not null,
  primary key (aid),
  foreign key (latitude, longitude) references Addresses (latitude, longitude)
                          on delete no action
                          on update cascade
);
