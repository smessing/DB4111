#!/usr/bin/python
# author: Samuel Messing <sbm2158@columbia.edu>

PROJECT_ID = 0
TEACHER_ACCT_ID = 1
SCHOOL_ID = 2
NCES_ID = 3
LATITUDE = 4
LONGITUDE = 5
CTIY = 6
STATE = 7
ZIP = 8
DISTRICT = 10
POVERTY_LEVEL = 27
GRADE_LEVEL = 28
TOTAL_PRICE = 34
TOTAL_DONATIONS = 37
NUM_DONORS = 38
EXPIRATION_DATE = 45


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
  project = line.split(',')
  data_map = {}
  for i in range(len(project)):
    data_map[i] = project[i]
  if (valid(data_map)):
    data = build_district_statement(data_map)
    district_out.write(data)
    data = build_address_statement(data_map)
    address_out.write(data)
    data = build_teacher_statement(data_map)
    teacher_out.write(data)
    data = build_school_statement(data_map)
    school_out.write(data)
    data = build_project_statement(data_map)
    project_out.write(data)

def valid(project_map):
  return data_map[CITY] = "\"New York\"" and data_map[STATE] = 'NY'


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