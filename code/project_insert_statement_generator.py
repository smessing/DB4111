#!/usr/bin/python
# author: Samuel Messing <sbm2158@columbia.edu>

data = file("../data/donorschoose-org-1may2011-v1-projects.csv", "r")
project_out = file("../data/project_insert_statements.sql", "w")
teacher_out = file("../data/teacher_insert_statements.sql", "w")
school_out = file("../data/school_insert_statements.sql", "w")
address_out = file("../data/address_insert_statements.sql", "w")
district_out = file("../data/district_insert_statements.sql", "w")

# skip header:
data.readline()

# process data:
for line in data.readlines():
  if (valid(line)):
    project = line.split(',')
    data = build_district_statement(project)
    district_out.write(data)
    data = build_address_statement(project)
    address_out.write(data)
    data = build_teacher_statement(project)
    teacher_out.write(data)
    data = build_school_statement(project)
    school_out.write(data)
    data = build_project_statement(project)
    project_out.write(data)


def build_project_statement(project):
  line_one = "INSERT INTO Projects_PROPOSE_AT\n"
  line_two = "(pid, fundURL, fundingStatus, fulfillmentTrailer," + \
             "expirationDate, totalPrice, title, subject, shortDescription," + \
             "proposalURL, percentFunded, imageURL, numStudents, tid, tName," + \
             "ncesId)\n"
  line_three = "VALUES\n"
  line_four = "()"
  return line_one + line_two + line_three + line_four

def build_teacher_statement(project):
  line_one = "INSERT INTO Teachers\n"
  line_two = "(tid, name)\n"
  line_three = "VALUES\n"
  line_four = "()"
  return line_one + line_two + line_three + line_four

def build_school_statement(project):
  line_one = "INSERT INTO Schools_S_IN_HAVE\n"
  line_two = "(ncesID, name, avgClassSize, poveryLevel, avgMathSATScore," +\
             "avgReadingSATScore, avgWritingSATScore, currentGrade," + \
             "progressGrade, graduationRate, percentAPAbove2, dNumber," + \
             "streetNumber, streetName, zipcode)\n"
  line_three = "VALUES\n"
  line_four = "()"
  return line_one + line_two + line_three + line_four

def build_address_statement(project):
  line_one = "INSERT INTO Addresses\n"
  line_two = "(latitude, longitude, streetNumber, streetName, zipcode)\n"
  line_three = "VALUES\n"
  line_four = "()"
  return line_one + line_two + line_three + line_four

def build_district_statement(project):
  line_one = "INSERT INTO Districts_D_IN\n"
  line_two = "(avgAttendance, percentRecvPublicAsst, dNumber, bName)\n"
  line_three = "VALUES\n"
  line_four = "(0.0, 0.0,)"
  return line_one + line_two + line_three + line_four