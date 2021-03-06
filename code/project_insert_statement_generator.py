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
23:'SUBJECT',
27:'POVERTY_LEVEL',
28:'GRADE_LEVEL',
32:'TRAILER',
34:'TOTAL_PRICE',
35:'NUM_STUDENTS',
37:'TOTAL_DONATIONS',
38:'NUM_DONORS',
41:'FUND_STATUS',
42:'DATE'
}

first_name_map = {
0:'Benjamin',
1:'John',
2:'Mary',
3:'Howard',
4:'Jack',
5:'Sarah',
6:'Lee',
7:'Cathy',
8:'Fred',
9:'Hannah',
10:'Edward'
}

last_name_map = {
0:'Olson',
1:'Jackson',
2:'Johnson',
3:'Messing',
4:'Rapaport',
5:'Obama',
6:'Smith',
7:'Baltair',
8:'Fieldson',
9:'Bergman',
10:'Fieldstein'
}

street_name_map = {
0:'Warren',
1:'Smith',
2:'High',
3:'Clapboardtree',
4:'Martingale',
5:'Broadway',
6:'Court',
7:'Hoyt',
8:'Osage',
9:'Pond',
10:'Buckmaster'
}

street_type_map = {
0:'St.',
1:'Ln.',
2:'Ave.',
3:'Rd.'
}

months = {
'01':'jan',
'02':'feb',
'03':'mar',
'04':'apr',
'05':'may',
'06':'jun',
'07':'jul',
'08':'aug',
'09':'sep',
'10':'oct',
'11':'nov',
'12':'jan'
}

users = {
0:'dan@fun.com',
1:'ben@fun.com',
2:'carl@fun.com',
3:'clarence@fun.com',
4:'abby@fun.com',
5:'Hannah@fun.com',
6:'Sam@fun.com',
7:'David@fun.com',
8:'debbie@fun.com',
9:'Martin@fun.com',
}

# Function Definitions:
def valid(project_map):
  return data_map['CITY'] == "New York" and data_map['STATE'] == 'NY' and \
         data_map['NCES_ID'] != ""


def build_vote_statement(data):
  line_one = "INSERT INTO Vote\n"
  line_two = "(vDate, tid, pid, email)\n"
  line_three = "VALUES\n"
  line_four = "('%(DATE)s','%(TEACHER_ACCT_ID)s','%(PROJECT_ID)s'," % data + \
              "'%s'" % users[random.randint(0,9)] + ");\n"
  return line_one + line_two + line_three + line_four

def build_project_statement(data):
  line_one = "INSERT INTO Projects_PROPOSE_AT\n"
  line_two = "(pid, fundURL, fundingStatus, fulfillmentTrailer, " + \
             "expirationDate, totalPrice, title, subject, shortDescription, " + \
             "proposalURL, percentFunded, imageURL, numStudents, tid, " + \
             "ncesId)\n"
  line_three = "VALUES\n"
  line_four = "('%(PROJECT_ID)s'," % data + "'http://fnd.donorschoose.org/" + \
              str(random.randint(0,1000)) + "','funding','%(TRAILER)s'," % data + \
              "'%(DATE)s',%(TOTAL_PRICE)s," % data + \
              "'Probably the best one ever','%(SUBJECT)s','" % data + \
              "This one will make kids smarter and happier than ever.'," + \
              "'http://www.donorschoose.org/prjcts/%(PROJECT_ID)s'," % data + \
              str(random.random()) + "," + \
              "'http://img.donorschoose.org/prjcts/%(PROJECT_ID)s'" % data + \
              ",%(NUM_STUDENTS)s,'%(TEACHER_ACCT_ID)s'" % data + \
              ",'%(NCES_ID)s');\n" % data
  return line_one + line_two + line_three + line_four

def build_teacher_statement(data):
  line_one = "INSERT INTO Teachers\n"
  line_two = "(tid, name)\n"
  line_three = "VALUES\n"
  line_four = "('%(TEACHER_ACCT_ID)s'," % data + \
              "'" + first_name_map[random.randint(0,10)] + " " + \
              last_name_map[random.randint(0,10)] + "');\n"
  return line_one + line_two + line_three + line_four

def build_school_statement(data):
  line_one = "INSERT INTO Schools_S_IN_S_HAVE\n"
  line_two = "(ncesID, name, avgClassSize, povertyLevel, avgMathSATScore," +\
             "avgReadingSATScore, avgWritingSATScore, currentGrade," + \
             "progressGrade, graduationRate, percentAPAbove2, dNumber," + \
             "latitude, longitude)\n"
  line_three = "VALUES\n"
  line_four = "(%(NCES_ID)s,'" % data + \
              first_name_map[random.randint(0,10)] + " " +\
              last_name_map[random.randint(0,10)] + " School'," +\
              str(random.random()) + ",'high'," + \
              str(random.randint(200,800)) + "," + \
              str(random.randint(200,800)) + "," + \
              str(random.randint(200,800)) + ",'A','B'," + \
              str(random.random()) + "," + str(random.random()) +\
              ",%(DISTRICT)s,%(LATITUDE)s,%(LONGITUDE)s);\n" % data
  return line_one + line_two + line_three + line_four

def build_address_statement(data):
  line_one = "INSERT INTO Addresses\n"
  line_two = "(latitude, longitude, streetNumber, streetName, zipcode, bName)\n"
  line_three = "VALUES\n"
  line_four = "(%(LATITUDE)s,%(LONGITUDE)s," % data +\
              "'" + str(random.randint(0,100)) + "','" + \
              street_name_map[random.randint(0,10)] + " " +\
              street_type_map[random.randint(0,3)]+ "'," + \
              "%(ZIPCODE)s,'Manhattan');\n" % data
  return line_one + line_two + line_three + line_four

def build_district_statement(data):
  line_one = "INSERT INTO Districts_D_IN\n"
  line_two = "(avgAttendance, percentRecvPublicAsst, dNumber, bName)\n"
  line_three = "VALUES\n"
  line_four = "("+str(random.random())+","+str(random.random())+\
  ",%(DISTRICT)s,'Manhattan');\n" % data
  return line_one + line_two + line_three + line_four

if __name__ == "__main__":

  data_file = file("../data/src/donorschoose-org-1may2011-v1-projects.csv", "r")
  project_out = file("../data/sql/project_insert_statements.sql", "w")
  #teacher_out = file("../data/sql/teacher_insert_statements.sql", "w")
  #school_out = file("../data/sql/school_insert_statements.sql", "w")
  #address_out = file("../data/sql/address_insert_statements.sql", "w")
  #district_out = file("../data/sql/district_insert_statements.sql", "w")
  vote_out = file("../data/sql/vote_insert_statements.sql", "w")
  district_map = {}

  # skip header:
  data_file.readline()

  # process data:
  for line in data_file.readlines():
    project = line.split(',')
    data_map = {}
    for i in range(len(project)):
      if (header_map.has_key(i)):
        if (header_map[i] == 'DATE'):
          formatting = project[i].rstrip('\n')
          if (formatting == 'completed' or formatting == 'live' or \
              formatting == 'expired' or formatting == 'reallocated'):
            formatting = '2011-03-21'
          date = formatting.split("-")
          data_map["%s" % header_map[i]] = date[2] + "-" + months[date[1]] + \
                                          "-" + date[0][2] + date[0][3]
        elif (header_map[i] == 'SUBJECT'):
          data_map["%s" % header_map[i]] = project[i].replace("&",'')
        else:
          data_map["%s" % header_map[i]] = project[i].replace('\"', '')
      else:
        data_map["%i" % i] = project[i]
      data_map['DISTRICT'] = random.randint(0,10)
    if (valid(data_map)):
      data = build_address_statement(data_map)
      #address_out.write(data)
      data = build_district_statement(data_map)
      #district_out.write(data)
      data = build_teacher_statement(data_map)
      #teacher_out.write(data)
      data = build_school_statement(data_map)
      #school_out.write(data)
      data = build_project_statement(data_map)
      project_out.write(data)
      data = build_vote_statement(data_map)
      vote_out.write(data)