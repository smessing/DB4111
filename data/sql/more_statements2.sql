INSERT INTO Addresses
(latitude, longitude, streetNumber, streetName, zipcode, bName)
VALUES
(40.83705,-73.865429,'666','Clark St.',11203,'The Bronx');

INSERT INTO Schools_S_IN_S_HAVE
(ncesID, name, avgClassSize, povertyLevel, avgMathSATScore,avgReadingSATScore, avgWritingSATScore, currentGrade,progressGrade, graduationRate, percentAPAbove2, dNumber,latitude, longitude)
VALUES
(0293865464530,'School For Gifted CS Students',0.70,'medium',800,300,350,'C','C',0.95,0.99,695,40.83705,-73.865429);

INSERT INTO Districts_D_IN
(avgAttendance, percentRecvPublicAsst, dNumber, bName)
VALUES
(.99,.15,695,'The Bronx');

INSERT INTO Projects_PROPOSE_AT
(pid, fundURL, fundingStatus, fulfillmentTrailer, expirationDate, totalPrice, title, subject, shortDescription, proposalURL, percentFunded, imageURL, numStudents, tid, ncesId)
VALUES
('752asdfasdfe93fdsdfs','http://www.donorschoose.org/donors/proposal.html?id=724229','funding','70.00','05-apr-13',5000,'How Can You Paint without Paint','Arts','My students are learning to mix colors, use paintbrushes to create different effects, and use the elements of art in a painting. Sixth Graders are painting Cubist portraits, Seventh Graders are painting Abstract paintings, and the Eighth Graders are painting cityscapes. They will not be able to finish if Im not able to provide them with paint! I am requesting Acrylic paint, paper and brush cleaner. ','http://www.donorschoose.org/we-teach/193753',0.804453837259,'http://www.donorschoose.org/donors/proposal.html?id=75234',100,'1111111',0293865464530);

INSERT INTO Teachers
(tid, name)
VALUES
('1111111','Ms. Filch');

