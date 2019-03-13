import gspread
import os
import sys
import requests
import json
from oauth2client.service_account import ServiceAccountCredentials
from django.http import HttpResponse

email = str(sys.argv[1])
ay = str(sys.argv[2])
term = str(sys.argv[3])
spreadsheetname = "Summary Reports for Minor and Major Cases for AY " + ay + " Term " + term

# use creds to create a client to interact with the Google Drive API
scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('client_secret.json', scope)
client = gspread.authorize(creds)
gc = gspread.authorize(creds)

#Create new spreadsheet
new = gc.create(spreadsheetname)
open = gc.open(spreadsheetname)
new.share(email, perm_type='user', role='reader')
sheet = client.open(spreadsheetname).sheet1

table = ["MINOR DISCIPLINE VIOLATIONS","","","","","","","","","","","",
		"Discipline Processes","Campus/Level","Frequency of Offenses", "", "College of Computer Studies","College of Liberal Arts","College of Business","School of Economics","Gokongwei College of Engineering","College of Science","College of Education","SUB-TOTAL",
		"Formative Case Conference with students where incidents were recorded but without any offense", "Graduate","No Academic Service (AS)", "","","","","","","","","",
		"","","With Academic Service", "","","","","","","","","",
		"","","VCDP (FORMS)", "","","","","","","","","",
		"","Undergraduate","No Academic Service (AS)", "","","","","","","","","",
		"","","With Academic Service", "","","","","","","","","",
		"","","VCDP (FORMS)", "","","","","","","","","",
		"Sub-Total", "","","","","","","","","","","",
		"Formative Case Conferences with Students w/ Minor Offenses","Graduate", "1st Offense", "w/ AS", "","","","","","","","",
		"", "Undergraduate", "", "w/o AS", "","","","","","","","",
		"", "Graduate", "2nd Offense", "w/ AS", "","","","","","","","",
		"", "Undergraduate", "", "w/o AS", "","","","","","","","",
		"", "Graduate", "3rd Offense", "w/ AS", "","","","","","","","",
		"", "Undergraduate", "", "w/o AS", "","","","","","","","",
		"", "Graduate", "4th Offense", "w/ AS", "","","","","","","","",
		"", "Undergraduate", "", "w/o AS", "","","","","","","","",
		"", "Graduate", "5th Offense", "w/ AS", "","","","","","","","",
		"", "Undergraduate", "", "w/o AS", "","","","","","","","",
		"Sub-Total", "","","","","","","","","","","",
		"GRAND TOTAL", "","","","","","","","","","","",]

t=0
cell_list = sheet.range('A1:L21')

for cell in cell_list:
	cell.value = (table[t]);
	t=t+1

sheet.update_cells(cell_list)

cols = ["E","F","G","H","I","J","K","L"]
rows = ["3","4","5","6","7","8","9","10","11","12",
		"13","14","15","16","17","18","19","20"]
		
###### BATCH PROCESSING OF DATA
cell_list = sheet.range('E3:K8')
argsnum = 4
for cell in cell_list:
	cell.value = (sys.argv[argsnum]);
	argsnum=argsnum+1
	
##Update in batch
sheet.update_cells(cell_list)

cell_list = sheet.range('E10:K19')
for cell in cell_list:
	cell.value = (sys.argv[argsnum]);
	argsnum=argsnum+1
	
##Update in batch
sheet.update_cells(cell_list)

##CALCULATING SUB-TOTALS
for x in range(len(rows)):
	for y in cols:
		cell = (y+rows[x])
		
		if y == "L":
			sum = "=SUM(E" + rows[x] + ":K" + rows[x] + ")"
			sheet.update_acell(cell, sum)
			
		if rows[x]=="9":
			sum = "=SUM(" + y + "3:" + y + "8)"
			sheet.update_acell(cell, sum)

		if rows[x]=="20":
			sum = "=SUM(" + y + "10:" + y + "19)"
			sheet.update_acell(cell, sum)
			
##CALCULATE GRAND TOTAL
grandtotal = "=SUM(E3:K8,E10:K19)"
sheet.update_acell("B21", grandtotal)

print("Report Generated!")