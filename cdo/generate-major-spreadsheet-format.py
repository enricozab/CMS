import gspread
import os
import sys
import requests
import json
from oauth2client.service_account import ServiceAccountCredentials
from django.http import HttpResponse
from gspread_formatting import *

sdfod = str(sys.argv[1])
cdo = str(sys.argv[2])
ay = str(sys.argv[3])
term = str(sys.argv[4])
reportnum = str(sys.argv[5])
spreadsheetname = "Report No. " + reportnum + " Summary Report for Major Cases for AY " + ay + " Term " + term

"""
file = open("C://xampp//htdocs//CMS//cdo//majorReport.txt", "a")
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

#Create Table First
table = ["MAJOR DISCIPLINE VIOLATIONS","","","","","","","","","","",
		"","","Level", "College of Computer Studies","College of Liberal Arts","College of Business","School of Economics","Gokongwei College of Engineering","College of Science","College of Education","TOTAL",
		"Cases/complaints", "", "Graduate", "","","","","","","","",
		"under processing","","Undergraduate", "","","","","","","","",
		"Dismissed Cases", "", "Graduate", "","","","","","","","",
		"","","Undergraduate", "","","","","","","","",
		"TOTAL", "","","","","","","","","","",
		"","","","","","","","","","","",
		"Case Heard Through:", "","","","","","","","","","",
		"UPCC", "","Graduate","","","","","","","","",
		"", "","Undergraduate","","","","","","","","",
		"SDFB", "Summary","Graduate","","","","","","","","",
		"", "Proceedings","Undergraduate","","","","","","","","",
		"", "Formal Hearings","Graduate","","","","","","","","",
		"", "","Undergraduate","","","","","","","","",
		"TOTAL", "","","","","","","","","",""]

tableIndex=0
cell_list = sheet.range('A1:K16')

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

boldCell = cellFormat(
    textFormat=textFormat(bold=True)
)

format_cell_range(worksheet, 'A2:K2', header)
format_cell_range(worksheet, 'A1', boldCell)
format_cell_range(worksheet, 'A7', boldCell)
format_cell_range(worksheet, 'A9', boldCell)
format_cell_range(worksheet, 'A16', boldCell)
