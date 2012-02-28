#!/usr/bin/python
# author: Samuel Messing <sbm2158@columbia.edu>

import random

header_map = {
0:'PROJECT_ID',
1:'TEACHER_ACCT_ID',
2:'SCHOOL_ID',
3:'NCES_ID',
4:'LATITUDE',
5:'LONGITUDE',
6:'CITY',
7:'STATE',
8:'ZIPCODE',
10:'DISTRICT',
11:'BOROUGH',
27:'POVERTY_LEVEL',
28:'GRADE_LEVEL',
34:'TOTAL_PRICE',
37:'TOTAL_DONATIONS',
38:'NUM_DONORS',
45:'EXPIRATION_DATE'
}

# Function Definitions:
def valid(project_map):
  return data_map['CITY'] == "\"New York\"" and data_map['STATE'] == 'NY' and \
         data_map['NCES_ID'] != ""


def build_project_statement(data):
  line_one = "INSERT INTO Projects_PROPOSE_AT\n"
  line_two = "(pid, fundURL, fundingStatus, fulfillmentTrailer," + \
             "expirationDate, totalPrice, title, subject, shortDescription," + \
             "proposalURL, percentFunded, imageURL, numStudents, tid, tName," + \
             "ncesId)\n"
  line_three = "VALUES\n"
  line_four = "();\n"
  return line_one + line_two + line_three + line_four

def build_teacher_statement(data):
  line_one = "INSERT INTO Teachers\n"
  line_two = "(tid, name)\n"
  line_three = "VALUES\n"
  line_four = "();\n"
  return line_one + line_two + line_three + line_four

def build_school_statement(data):
  line_one = "INSERT INTO Schools_S_IN_HAVE\n"
  line_two = "(ncesID, name, avgClassSize, poveryLevel, avgMathSATScore," +\
             "avgReadingSATScore, avgWritingSATScore, currentGrade," + \
             "progressGrade, graduationRate, percentAPAbove2, dNumber," + \
             "latitdue, longitude)\n"
  line_three = "VALUES\n"
  line_four = "(%(NCES_ID)s,'John Smith School',0.0,'high',600," + \
              "784,650,A," + \
              "B,0.45,0.37,1,%(LATITUDE)s,%(LONGITUDE)s);\n" % data
  return line_one + line_two + line_three + line_four

def build_address_statement(data):
  line_one = "INSERT INTO Addresses\n"
  line_two = "(latitude, longitude, streetNumber, streetName, zipcode)\n"
  line_three = "VALUES\n"
  line_four = "(%(LATITUDE)s,%(LONGITUDE)s,'14','Junk St.',%(ZIPCODE)s);\n" % data
  return line_one + line_two + line_three + line_four

def build_district_statement(data):
  line_one = "INSERT INTO Districts_D_IN\n"
  line_two = "(avgAttendance, percentRecvPublicAsst, dNumber, bName)\n"
  line_three = "VALUES\n"
  line_four = "(0.0,0.0,1,Manhattan);\n" % data
  return line_one + line_two + line_three + line_four

if __name__ == "__main__":

  data_file = file("../data/donorschoose-org-1may2011-v1-projects.csv", "r")
  #project_out = file("../data/project_insert_statements.sql", "w")
  #teacher_out = file("../data/teacher_insert_statements.sql", "w")
  #school_out = file("../data/school_insert_statements.sql", "w")
  address_out = file("../data/address_insert_statements.sql", "w")
  district_out = file("../data/district_insert_statements.sql", "w")
  district_map = {}

  # skip header:
  data_file.readline()

  # process data:
  for line in data_file.readlines():
    project = line.split(',')
    data_map = {}
    for i in range(len(project)):
      if (header_map.has_key(i)):
        data_map["%s" % header_map[i]] = project[i]
      else:
        data_map["%i" % i] = project[i]
      data_map['DISTRICT'] = random.randint(0,27)
    if (valid(data_map)):
      data = build_address_statement(data_map)
      address_out.write(data)
      data = build_district_statement(data_map)
      district_out.write(data)
      #data = build_teacher_statement(data_map)
      #print data
      #teacher_out.write(data)
      data = build_school_statement(data_map)
      print data
      #school_out.write(data)
      #data = build_project_statement(data_map)
      #project_out.write(data)