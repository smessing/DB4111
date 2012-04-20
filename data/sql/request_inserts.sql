insert into projects_request 
(pid, tid, book, requestDate, requestQuant)
values (
'752asdfasdfe934', '428954', select book_typ (REF(b)) from book_typ_table b where b.isbn='0439708184', 1334950342, 50
);


INSERT INTO After_School_Programs_A_HAVE
(aid, name, programType, agencyName, organizationName, elementaryLevel, 
  middleSchoolLevel, highSchoolLevel, organizationPhoneNumber, 
  latitude, longitude)
VALUES
('13', 'Community Association Progressive Dominicans', 'After-School Programs', 
  'Beacon', 'MS 117', 'T', 'T', 'T', '718-466-1806', 
  40.84854841840716, -73.90843506819625);