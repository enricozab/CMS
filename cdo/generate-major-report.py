import gspread
import os
import sys
import requests
import json
from oauth2client.service_account import ServiceAccountCredentials
from django.http import HttpResponse

sdfod = str(sys.argv[1])
cdo = str(sys.argv[2])
ay = str(sys.argv[3])
term = str(sys.argv[4])
reportnum = str(sys.argv[5])
spreadsheetname = "Report No. " + reportnum + " Summary Report for Major Cases for AY " + ay + " Term " + term

# use creds to create a client to interact with the Google Drive API
scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('client_secret.json', scope)
client = gspread.authorize(creds)
gc = gspread.authorize(creds)

#Create new spreadsheet
#new = gc.create(spreadsheetname)
open = gc.open(spreadsheetname)
sheet = client.open(spreadsheetname).sheet1

#Create Table First
table = ["MAJOR DISCIPLINE VIOLATIONS","","","","","","","","","","",
		"","","Level", "College of Computer Studies","College of Liberal Arts","College of Business","School of Economics","Gokongwei College of Engineering","College of Science","College of Education","TOTAL",
		"Cases/complaints under processing", "", "Graduate", "","","","","","","","",
		"","","Undergraduate", "","","","","","","","",
		"Dismissed Cases", "", "Graduate", "","","","","","","","",
		"","","Undergraduate", "","","","","","","","",
		"TOTAL", "","","","","","","","","","",
		"","","","","","","","","","","",
		"Case Heard Through:", "","","","","","","","","","",
		"UPCC", "","Graduate","","","","","","","","",
		"", "","Undergraduate","","","","","","","","",
		"SDFB", "Summary Proceedings","Graduate","","","","","","","","",
		"", "","Undergraduate","","","","","","","","",
		"", "Formal Hearings","Graduate","","","","","","","","",
		"", "","Undergraduate","","","","","","","","",
		"TOTAL", "","","","","","","","","",""]

# tableIndex=0
# cell_list = sheet.range('A1:K16')
#
# for cell in cell_list:
# 	cell.value = (table[tableIndex]);
# 	tableIndex=tableIndex+1
#
# sheet.update_cells(cell_list)

###### BATCH PROCESSING OF DATA - Input Data
cell_list = sheet.range('D3:J6')
argsnum = 6
for cell in cell_list:
	cell.value = (int(sys.argv[argsnum]));
	argsnum=argsnum+1

##Update in batch
sheet.update_cells(cell_list)

cell_list = sheet.range('D10:J15')
for cell in cell_list:
	cell.value = (int(sys.argv[argsnum]));
	argsnum=argsnum+1

##Update in batch
sheet.update_cells(cell_list)

cols = ["D","E","F","G","H","I","J","K"]
rows = ["3","4","5","6","7","10","11","12",
		"13","14","15","16"]
sum = ""
##CALCULATING SUB-TOTALS
for x in range(len(rows)):
	for y in cols:
		cell = (y+rows[x])

		if y == "K":
			sum = "=SUM(D" + rows[x] + ":J" + rows[x] + ")"
			sheet.update_acell(cell, sum)

		if rows[x]=="7":
			sum = "=SUM(" + y + "3:" + y + "6)"
			sheet.update_acell(cell, sum)

		if rows[x]=="16":
			sum = "=SUM(" + y + "10:" + y + "15)"
			sheet.update_acell(cell, sum)

##CALCULATE GRAND TOTAL
#grandtotal = "=SUM(E3:K8,E10:K19)"
#sheet.update_acell("B21", grandtotal)

##Share sheets to sdfod. Change role='reader' for final
open.share(sdfod, perm_type='user', role='reader')
open.share(cdo, perm_type='user', role='reader')
