import gspread
import os
import sys
import requests
import json
from oauth2client.service_account import ServiceAccountCredentials
from django.http import HttpResponse
from gspread_formatting import *

email = str(sys.argv[1])
ay = str(sys.argv[2])
term = str(sys.argv[3])
reportnum = str(sys.argv[4])
spreadsheetname = "Report No. " + reportnum + " Summary Report for Minor Cases for AY " + ay + " Term " + term

"""
file = open("C://xampp//htdocs//CMS//cdo//minorReport.txt", "a")
file.write(str(sys.argv))
"""

# use creds to create a client to interact with the Google Drive API
scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('client_secret.json', scope)
client = gspread.authorize(creds)
gc = gspread.authorize(creds)

#Create new spreadsheet
new = gc.create(spreadsheetname)
open = gc.open(spreadsheetname)
sheet = client.open(spreadsheetname).sheet1
worksheet = open.get_worksheet(0)

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

tableIndex=0
cell_list = sheet.range('A1:L21')

for cell in cell_list:
	cell.value = (table[tableIndex]);
	tableIndex=tableIndex+1

sheet.update_cells(cell_list)

#FORMAT TABLE
header = cellFormat(
    backgroundColor=color(0.878, 0.878, 0.878),
    textFormat=textFormat(bold=True, foregroundColor=color(0.090, 0.090, 0.090)),
    horizontalAlignment='CENTER',
	wrapStrategy="WRAP"
    )
colorCell = cellFormat(
	backgroundColor=color(0.878, 0.878, 0.878),
    textFormat=textFormat(bold=True, foregroundColor=color(0.090, 0.090, 0.090))
)
boldCell = cellFormat(
    textFormat=textFormat(bold=True)
)

format_cell_range(worksheet, 'A2:B2', header)
format_cell_range(worksheet, 'E2:L2', header)
format_cell_range(worksheet, 'C2:D2', colorCell)
format_cell_range(worksheet, 'A1', boldCell)
format_cell_range(worksheet, 'A9', boldCell)
format_cell_range(worksheet, 'A20', boldCell)
format_cell_range(worksheet, 'A21', boldCell)
